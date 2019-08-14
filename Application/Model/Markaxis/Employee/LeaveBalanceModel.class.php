<?php
namespace Markaxis\Employee;
use \Markaxis\Leave\TypeModel, \Markaxis\Leave\OfficeModel;
use \Library\Helper\Aurora\DayHelper, \Library\Util\Date;
use \DateTime;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: LeaveBalanceModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveBalanceModel extends \Model {


    // Properties
    protected $LeaveBalance;


    /**
     * LeaveBalanceModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Leave/LeaveRes');

        $this->LeaveBalance = new LeaveBalance( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByltID( $ltID ) {
        return $this->LeaveBalance->isFoundByltID( $ltID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByUserID( $userID, $limit=false ) {
        if( $limit ) {
            $this->LeaveBalance->setLimit(0, $limit );
        }
        return $this->LeaveBalance->getByUserID( $userID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByltIDUserID( $ltID, $userID ) {
        return $this->LeaveBalance->getByltIDUserID( $ltID, $userID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getTypeListByUserID( $userID ) {
        return $this->info = $this->LeaveBalance->getTypeListByUserID( $userID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getSidebar( ) {
        $EmployeeModel = EmployeeModel::getInstance( );
        $empInfo = $EmployeeModel->getInfo( );

        $this->info = $this->LeaveBalance->getSidebarByUserID( $empInfo['userID'] );
        return $this->info;
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function updateUserBalance( $userID, $leaveTypes ) {
        foreach( $leaveTypes as $type ) {
            $totalApplied = isset( $type['totalApplied'] ) ? $type['totalApplied'] : 0;
            $totalLeaves  = isset( $type['totalLeaves']  ) ? $type['totalLeaves']  : 0;

            $info = array( );
            $info['totalLeaves'] = (float)$totalLeaves;
            $info['totalApplied'] = (float)$totalApplied;
            $info['balance'] = $info['totalLeaves']-$info['totalApplied'];

            if( !$this->getByltIDUserID( $type['ltID'], $userID ) ) {
                $info['ltID'] = $type['ltID'];
                $info['userID'] = (int)$userID;
                $this->LeaveBalance->insert( 'employee_leave_bal', $info );
            }
            else {
                $this->LeaveBalance->update('employee_leave_bal', $info,
                                            'WHERE ltID = "' . (int)$type['ltID'] . '" AND
                                                          userID = "' . (int)$userID . '"' );
            }
        }
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
     * Set User Property Info
     * @return bool
     */
    public function applyIsValid( $data ) {
        if( !$data['ltID'] ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_CHOOSE_LEAVE_TYPE') );
            return false;
        }

        $EmployeeModel = EmployeeModel::getInstance( );
        $empInfo = $EmployeeModel->getInfo( );
        $this->info['userID'] = $empInfo['userID'];

        if( $balInfo = $this->getByltIDUserID( $data['ltID'], $this->info['userID'] ) ) {
            if( isset( $data['startDate'] ) && isset( $data['endDate'] ) ) {
                $this->info['startDate'] = DateTime::createFromFormat('d M Y', $data['startDate'] );
                $this->info['endDate']   = DateTime::createFromFormat('d M Y', $data['endDate'] );

                if( !$this->info['startDate'] || !$this->info['endDate'] || !$this->info['days'] = $this->calculateDateDiff( $data ) ) {
                    $this->setErrMsg( $this->L10n->getContents('LANG_INVALID_DATE_RANGE') );
                    return false;
                }
                else {
                    if( $this->info['days'] > $balInfo['balance'] ) {
                        $this->setErrMsg( $this->L10n->getContents('LANG_INSUFFICIENT_LEAVE') );
                        return false;
                    }
                    $this->info['balance'] = (float)$balInfo['balance']-$this->info['days'];
                    return true;
                }
            }
        }
        $this->setErrMsg( $this->L10n->getContents('LANG_INVALID_BALANCE') );
        return false;
    }
}
?>