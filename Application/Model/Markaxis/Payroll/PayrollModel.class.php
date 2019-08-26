<?php
namespace Markaxis\Payroll;
use \Library\Security\Aurora\LockMethod;
use \Library\Validator\Validator;
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
     * Return total count of records
     * @return int
     */
    public function getProcessByDate( $processDate, $completed ) {
        return $this->Payroll->getUserProcessByDate( $processDate, $completed );
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

                if( $pass ) {
                    if( $date ) {
                        $method = 'payroll_process_' . $date->format('Y-m-d');

                        $LockMethod = new LockMethod( );
                        if( $LockMethod->verify( $pass ) ) {
                            if( $LockMethod->allow( $method ) ) {
                                $LockMethod->logEntry( $method );
                                return true;
                            }
                        }
                    }
                }
                else {
                    $this->errMsg = $this->L10n->getContents( 'LANG_ENTER_PASSWORD' );
                }
            }
            catch( AuthLoginException $e ) {
                $this->errMsg = $this->L10n->getContents( 'LANG_VERIFICATION_FAILED' );
            }
        }
        $this->errMsg = $this->L10n->getContents( 'LANG_VERIFICATION_FAILED' );
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
        $summary['gross'] = $summary['deduction'] = $summary['net'] = $summary['claim'] =
        $summary['fwl'] = $summary['sdl'] = $summary['levy'] = $summary['contribution'] = 0;

        if( isset( $data['gross'] ) ) {
            foreach( $data['gross'] as $gross ) {
                if( isset( $gross['amount'] ) ) {
                    $summary['gross'] += (float)$gross['amount'];
                    $summary['net'] += (float)$gross['amount'];
                }
            }
        }
        if( isset( $data['net'] ) ) {
            foreach( $data['net'] as $net ) {
                if( isset( $net['amount'] ) ) {
                    $summary['net'] += (float)$net['amount'];
                }
            }
        }
        if( isset( $data['items'] ) && is_array( $data['items'] ) ) {
            foreach( $data['items'] as $items ) {
                if( isset( $data['deduction'] ) ) {
                    $summary['deduction'] += (float)$items['amount'];
                    $summary['net'] -= (float)$items['amount'];
                }
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
        if( isset( $data['skillLevy'] ) ) {
            $summary['sdl'] += (float)$data['skillLevy']['amount'];
            $summary['levy'] += (float)$data['skillLevy']['amount'];
        }
        if( isset( $data['foreignLevy'] ) ) {
            $summary['fwl'] += (float)$data['foreignLevy']['amount'];
            $summary['levy'] += (float)$data['foreignLevy']['amount'];
        }
        if( isset( $data['contribution'] ) && is_array( $data['contribution'] ) ) {
            foreach( $data['contribution'] as $contribution ) {
                $summary['contribution'] += (float)$contribution['amount'];
            }
        }
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