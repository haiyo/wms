<?php
namespace Markaxis\Leave;
use \Markaxis\Employee\LeaveBalanceModel, \Markaxis\Employee\EmployeeModel;
use \Aurora\Notification\NotificationModel;
use \Library\Helper\Aurora\DayHelper, \Library\Util\Date;
use \DateTime;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: LeaveApplyModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveApplyModel extends \Model {


    // Properties
    protected $LeaveApply;



    /**
     * LeaveApplyModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Leave/LeaveRes');

        $this->LeaveApply = new LeaveApply( );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getByUserID( $userID ) {
        return $this->Claim->getByUserID( $userID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getPendingAction( $userID ) {
        return $this->LeaveApply->getPendingAction( $userID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getHistory( $post ) {
        $this->LeaveApply->setLimit( $post['start'], $post['length'] );

        $order = 'la.created';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'lt.name';
                    break;
                case 2:
                    $order = 'la.reason';
                    break;
                case 3:
                    $order = 'la.approved';
                    break;
                case 4:
                    $order = 'la.created';
                    break;
            }
        }
        $results = $this->LeaveApply->getHistory( $post['search']['value'], $order . $dir );

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
    public function setStatus( $laID, $status ) {
        $this->LeaveApply->update('leave_apply', array( 'status' => $status ),
                                  'WHERE laID = "' . (int)$laID . '"' );
    }


    /**
     * Set User Property Info
     * @return mixed
     */
    public function calculateBalance( array $balance ) {
        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );
        $applied = $this->LeaveApply->getSidebarByUserID( $userInfo['userID'] );

        foreach( $balance as $key => $value ) {
            if( isset( $applied[$value['ltID']] ) && isset( $balance[$key]['balance'] ) ) {
                $balance[$key]['balance'] -= $applied[$value['ltID']];
            }
        }
        return $balance;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function processPayroll( $userID, $data ) {
        /*$applyInfo = $this->getByuserID( $userID );

        if( sizeof( $applyInfo ) > 0 ) {
            foreach( $applyInfo as $value ) {
                $data['items'][$value['ecID']] = array( 'eiID' => $value['eiID'],
                                                        'title' => $value['descript'],
                                                        'amount' => $value['amount'] );
            }
        }
        return $data;*/
    }


    /**
     * Set User Property Info
     * @return bool
     */
    public function applyIsValid( $data ) {
        if( !$data['ltID'] ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_CHOOSE_LEAVE_TYPE') );
            return false;
        }
        $LeaveBalanceModel = LeaveBalanceModel::getInstance( );

        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        if( $balInfo = $LeaveBalanceModel->getByltIDUserID( $data['ltID'], $userInfo['userID'] ) ) {
            if( isset( $data['startDate'] ) && isset( $data['endDate'] ) ) {
                $startDate = DateTime::createFromFormat('d M Y', $data['startDate'] );
                $endDate = DateTime::createFromFormat('d M Y', $data['endDate'] );

                if( !$startDate || !$endDate || !$days = $this->calculateDateDiff( $data ) ) {
                    $this->setErrMsg( $this->L10n->getContents('LANG_INVALID_DATE_RANGE') );
                    return false;
                }
                else {
                    if( $days > $balInfo['balance'] ) {
                        $this->setErrMsg( $this->L10n->getContents('LANG_INSUFFICIENT_LEAVE') );
                        return false;
                    }
                    $this->info['userID'] = $userInfo['userID'];
                    $this->info['ltID'] = $data['ltID'];
                    $this->info['reason'] = $data['reason'];
                    $this->info['startDate'] = $startDate->format('Y-m-d');
                    $this->info['endDate'] = $endDate->format('Y-m-d');
                    $this->info['days'] = $days;
                    $this->info['created'] = date( 'Y-m-d H:i:s' );
                    return true;
                }
            }
        }
        return false;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function calculateDateDiff( $data ) {
        $firstHalf  = ( isset( $data['firstHalf']  ) && $data['firstHalf']  ) ? 1 : 0;
        $secondHalf = ( isset( $data['secondHalf'] ) && $data['secondHalf'] ) ? 1 : 0;

        if( !$data['ltID'] ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_CHOOSE_LEAVE_TYPE') );
            return false;
        }
        if( !$data['startDate'] || !$data['endDate'] ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_INVALID_DATE_RANGE') );
            return false;
        }

        // Get leave type to check if half day allowed
        $TypeModel = TypeModel::getInstance( );

        if( $typeInfo = $TypeModel->getByID( $data['ltID'] ) ) {
            if( !$typeInfo['allowHalfDay'] && ( $data['firstHalf']  == 1 || $data['secondHalf'] == 1 ) ) {
                $this->setErrMsg( $this->L10n->getContents('LANG_HALF_DAY_NOT_ALLOWED') );
                return false;
            }
            $EmployeeModel = EmployeeModel::getInstance( );
            $empInfo = $EmployeeModel->getInfo( );

            // Get office time shift
            $OfficeModel = OfficeModel::getInstance( );

            if( $officeInfo = $OfficeModel->getOffice( $data['ltID'], $empInfo['officeID'] ) ) {
                $startDate  = DateTime::createFromFormat('d M Y', $data['startDate'] );
                $endDate    = DateTime::createFromFormat('d M Y', $data['endDate'] );
                $daysDiff   = Date::daysDiff( $startDate, $endDate );

                // Create an iterateable period of date (P1D equates to 1 day)
                $period   = new \DatePeriod( $startDate, new \DateInterval('P1D'), $endDate );
                $workDays = array( );
                $dayList  = DayHelper::getL10nNumericValueList( );
                $started  = false;

                foreach( $dayList as $dayNumberic => $day ) {
                    if( $dayNumberic == $officeInfo['workDayFrom'] ) {
                        $workDays[$dayNumberic] = $started = true;
                    }
                    if( $dayNumberic == $officeInfo['workDayTo'] ) {
                        $workDays[$dayNumberic] = true;
                        $started = false;
                    }
                    if( $started ) {
                        $workDays[$dayNumberic] = true;
                    }
                }
                foreach( $period as $dt ) {
                    $curr = strtolower( $dt->format('N') );

                    // substract non working days
                    if( !isset( $workDays[$curr] ) ) {
                        $daysDiff--;
                    }
                }
                if( $firstHalf  ) { $daysDiff -= .5; }
                if( $secondHalf ) { $daysDiff -= .5; }
                return $daysDiff;
            }
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function save( ) {
        return $this->info['laID'] = $this->LeaveApply->insert('leave_apply', $this->info );
    }
}
?>