<?php
namespace Markaxis\Payroll;
use \Aurora\User\UserImageModel;
use \Library\Security\Aurora\LockMethod;
use \Library\Validator\Validator;
use \Library\Util\Date;
use \Library\Exception\Aurora\AuthLoginException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: PayrollModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollModel extends \Model {


    // Properties
    protected $Payroll;
    private $totalOrdinary;


    /**
     * PayrollModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->Payroll = new Payroll( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $prID ) {
        return $this->Payroll->isFound( $prID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByRange( $startDate, $endDate, $userID=false ) {
        return $this->Payroll->getByRange( $startDate, $endDate, $userID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getCalculateUserInfo( $userID ) {
        return $this->Payroll->getCalculateUserInfo( $userID );
    }


    /**
     * Retrieve Events Between a Start and End Timestamp
     * @return mixed
     */
    public function getEventsBetween( $info ) {
        $eventList = array( );

        if( isset( $info['start'] ) && isset( $info['end'] ) ) {
            $startDate = Date::parseDateTime( $info['start'] );
            $endDate = Date::parseDateTime( $info['end'] );

            $eventList = $this->Payroll->getEventsBetween( $startDate, $endDate );
        }
        return $eventList;
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post, $processDate, $officeID ) {
        $this->Payroll->setLimit( $post['start'], $post['length'] );

        $order = 'name';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'e.idnumber';
                    break;
                case 2:
                    $order = 'name';
                    break;
                case 3:
                    $order = 'd.title';
                    break;
                case 4:
                    $order = 'e.email1';
                    break;
                case 5:
                    $order = 'u.mobile';
                    break;
                case 6:
                    $order = 'u.suspended';
                    break;
            }
        }
        $results = $this->Payroll->getResults( $processDate, $officeID, $post['search']['value'], $order . $dir );

        if( $results ) {
            $UserImageModel = UserImageModel::getInstance( );

            foreach( $results as $key => $row ) {
                if( isset( $row['userID'] ) ) {
                    $results[$key]['photo'] = $UserImageModel->getImgLinkByUserID( $row['userID'] );
                }
            }
        }

        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$post['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getProcessByDate( $processDate, $completed='' ) {
        return $this->Payroll->getProcessByDate( $processDate, $completed );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function setCompleted( $post ) {
        if( isset( $post['processDate'] ) ) {
            $info = array( );
            $info['completed'] = 1;
            $this->Payroll->update('payroll', $info, 'WHERE startDate = "' . addslashes( $post['processDate'] ) . '"');
            return true;
        }
        return false;
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function calculateCurrYearOrdinary( $userID, $cappedLimit=false ) {
        if( $this->totalOrdinary ) {
            return $this->totalOrdinary;
        }
        $year = date('Y');
        $startDate = date('Y-m-d', mktime(0, 0, 0, 1, 1, $year) );
        $endDate = date('Y-m-d', mktime(0, 0, 0, 12, 31, $year) );

        $range = $this->Payroll->getByRange( $startDate, $endDate, $userID );
        $this->totalOrdinary = array( 'months' => sizeof( $range ), 'amount' => 0 );

        foreach( $range as $payroll ) {
            if( $cappedLimit && $payroll['ordinary'] > $cappedLimit ) {
                $this->totalOrdinary['amount'] += $cappedLimit;
            }
            else {
                $this->totalOrdinary['amount'] += $payroll['ordinary'];
            }
        }
        return $this->totalOrdinary;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function allowProcessPass( $data ) {
        if( isset( $data['password'] ) && isset( $data['processDate'] ) ) {
            try {
                $pass = Validator::stripTrim( $data['password'] );
                $date = \DateTime::createFromFormat('Y-m-d', $data['processDate'] );

                if( $pass && $date ) {
                    $method = 'payroll_process_' . $date->format('Y-m-d');

                    $LockMethod = new LockMethod( );
                    if( $LockMethod->verify( $pass ) && $LockMethod->allow( $method ) ) {
                        $LockMethod->logEntry( $method );
                        return true;
                    }
                }
                else {
                    $this->errMsg = $this->L10n->getContents('LANG_ENTER_PASSWORD');
                }
            }
            catch( AuthLoginException $e ) {
                $this->errMsg = $this->L10n->getContents('LANG_VERIFICATION_FAILED');
            }
        }
        $this->errMsg = $this->L10n->getContents('LANG_VERIFICATION_FAILED');
        return false;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function createPayroll( $startDate ) {
        $DateTime = \DateTime::createFromFormat('Y-m-d', $startDate );

        if( $DateTime ) {
            $info = array( );
            $info['startDate'] = $startDate;
            $info['endDate'] = $DateTime->format('Y-m-') . $DateTime->format('t');
            $info['created'] = date( 'Y-m-d H:i:s' );
            return $this->Payroll->insert( 'payroll', $info );
        }
        return false;
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function processSummary( $data ) {
        $summary['gross'] = $summary['net'] = (float)$data['items']['totalOrdinary'];

        $summary['deduction'] = $summary['claim'] = $summary['fwl'] = $summary['sdl'] =
        $summary['levy'] = $summary['contribution'] = $summary['totalContribution'] = 0;

        if( isset( $data['addGross'] ) ) {
            foreach( $data['addGross'] as $addGross ) {
                $summary['gross'] += (float)$addGross;
                $summary['net']   += (float)$addGross;
            }
        }

        if( isset( $data['deductGross'] ) ) {
            foreach( $data['deductGross'] as $addGross ) {
                $summary['gross'] -= (float)$addGross;
                $summary['net']   -= (float)$addGross;
            }
        }

        if( isset( $data['claims'] ) ) {
            foreach( $data['claims'] as $claims ) {
                if( isset( $claims['eiID'] ) ) {
                    $summary['claim'] += (float)$claims['amount'];
                    $summary['net'] += (float)$claims['amount'];
                }
            }
        }

        if( isset( $data['itemRow'] ) && is_array( $data['itemRow'] ) ) {
            foreach( $data['itemRow'] as $item ) {
                if( isset( $item['deductGross'] ) ) {
                    $summary['gross'] -= (float)$item['amount'];
                }
                if( isset($item['deduction']) || isset( $item['deductionAW'] ) ) {
                    $summary['net'] -= (float)$item['amount'];
                }

                foreach( $data['taxGroups']['mainGroup'] as $key => $taxGroup ) {
                    // First find all the childs in this group and see if we have any summary=1
                    if( isset( $taxGroup['child'] ) ) {
                        $tgIDChilds = array_unique( array_column( $taxGroup['child'],'tgID' ) );

                        if( isset( $item['tgID'] ) && in_array( $item['tgID'], $tgIDChilds ) ) {
                            foreach( $taxGroup['child'] as $childKey => $child ) {
                                if( isset( $child['tgID'] ) && $child['tgID'] == $item['tgID'] ) {
                                    if( $child['summary'] ) {
                                        $summary['itemGroups'][$childKey]['title'] = $child['title'];
                                        $summary['itemGroups'][$childKey]['remark'] = $item['remark'];
                                    }
                                    else {
                                        $summary['itemGroups'][$childKey]['title'] = $data['taxGroups']['mainGroup'][$child['parent']]['title'];
                                    }

                                    if( isset( $summary['itemGroups'][$childKey]['amount'] ) ) {
                                        $summary['itemGroups'][$childKey]['amount'] += (float)$item['amount'];
                                    }
                                    else {
                                        $summary['itemGroups'][$childKey]['amount'] = (float)$item['amount'];
                                    }
                                    break 2;
                                }
                            }
                        }
                    }
                    else if( isset( $taxGroup['tgID'] ) && isset( $item['tgID'] ) && $taxGroup['tgID'] == $item['tgID'] ) {
                        // If children not found with summary=1, fallback to parent
                        $summary['itemGroups'][$key]['title'] = $taxGroup['title'];
                        $summary['itemGroups'][$key]['amount'] = (float)$item['amount'];
                        break;
                    }
                }
            }
        }
/*
        if( isset( $data['skillLevy'] ) ) {
            $summary['sdl'] += (float)$data['skillLevy']['amount'];
            $summary['levy'] += (float)$data['skillLevy']['amount'];
        }
        if( isset( $data['foreignLevy'] ) ) {
            $summary['fwl'] += (float)$data['foreignLevy']['amount'];
            $summary['levy'] += (float)$data['foreignLevy']['amount'];
        }
        */
        return $summary;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function savePayroll( $post ) {
        if( $processInfo = $this->getProcessByDate( $post['data']['processDate'],0 ) ) {
            return $processInfo['pID'];
        }
        else {
            return $this->createPayroll( $post['data']['processDate'] );
        }
    }
}
?>