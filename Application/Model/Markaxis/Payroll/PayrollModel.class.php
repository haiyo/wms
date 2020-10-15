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
    public function getBypID( $pID ) {
        return $this->Payroll->getBypID( $pID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByRange( $startDate, $endDate ) {
        return $this->Payroll->getByRange( $startDate, $endDate );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getUserTotalOWByRange( $userID, $cappedLimit=false ) {
        if( $this->totalOrdinary ) {
            return $this->totalOrdinary;
        }
        $year = date('Y');
        $startDate = date('Y-m-d', mktime(0, 0, 0, 1, 1, $year) );
        $endDate = date('Y-m-d', mktime(0, 0, 0, 12, 31, $year) );

        $range = $this->Payroll->getUserTotalOWByRange( $startDate, $endDate, $userID );
        $amount = 0;

        foreach( $range as $payroll ) {
            if( $cappedLimit && $payroll['gross'] > $cappedLimit ) {
                $amount += $cappedLimit;
            }
            else {
                $amount += $payroll['gross'];
            }
        }
        return $amount;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getProcessByDate( $processDate, $completed='' ) {
        return $this->Payroll->getProcessByDate( $processDate, $completed );
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
    public function getResults( $post, $pID, $officeID ) {
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
        $results = $this->Payroll->getResults( $pID, $officeID, $post['search']['value'], $order . $dir );

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
     * @return int
     */
    public function savePayroll( $post ) {
        if( $processInfo = $this->getProcessByDate( $post['data']['processDate'],0 ) ) {
            return $processInfo['pID'];
        }
    }
}
?>