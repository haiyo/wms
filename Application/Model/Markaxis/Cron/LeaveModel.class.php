<?php
namespace Markaxis\Cron;
use \Markaxis\Employee\LeaveBalance;
use \Markaxis\Employee\EmployeeModel;
use \Markaxis\Employee\LeaveBalanceModel;
use \Markaxis\Employee\LeaveTypeModel;
use \Markaxis\Leave\TypeModel;
use \Markaxis\Leave\GroupModel;
use \Markaxis\Leave\DesignationModel;
use \Markaxis\Leave\ContractModel;
use \Markaxis\Leave\StructureModel;
use \Markaxis\Leave\LeaveApplyModel;
use \Aurora\User\ChildrenModel;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: HolidayModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveModel extends \Model {


    // Properties
    protected $LeaveBalance;


    /**
     * LeaveModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->LeaveBalance = new LeaveBalance( );
        $this->calculateLeaveBalance( );
    }


    /**
     * Return total count of records
     * @return void
     */
    public function calculateLeaveBalance( ) {
        echo "Calculate Leave Balance Initialized...\n";

        $EmployeeModel = EmployeeModel::getInstance( );
        $ChildrenModel = ChildrenModel::getInstance( );
        $employees = $EmployeeModel->getList( );

        if( sizeof( $employees ) > 0 ) {
            $LeaveTypeModel = LeaveTypeModel::getInstance( );
            $TypeModel = TypeModel::getInstance( );
            $LeaveBalanceModel = LeaveBalanceModel::getInstance( );

            $GroupModel = GroupModel::getInstance( );
            $DesignationModel = DesignationModel::getInstance( );
            $ContractModel = ContractModel::getInstance( );
            $StructureModel = StructureModel::getInstance( );
            $LeaveApplyModel = LeaveApplyModel::getInstance( );

            foreach( $employees as $empInfo ) {
                /*if( $empInfo['userID'] != 33 ) {
                    continue;
                }*/

                $empInfo['children'] = $ChildrenModel->getByUserID( $empInfo['userID'] );

                $ltIDs = array_column( $LeaveTypeModel->getByUserID( $empInfo['userID'], 'ltID' ), 'ltID' );
                $leaveTypes = $TypeModel->getByIDs( $ltIDs );

                $leaveTypes = $GroupModel->getByLeaveTypes( $leaveTypes );
                $leaveTypes = $DesignationModel->getByGroups( $leaveTypes );
                $leaveTypes = $ContractModel->getByGroups( $leaveTypes );
                $leaveTypes = $StructureModel->getByGroups( $empInfo, $leaveTypes );
                $leaveTypes = $LeaveApplyModel->getByUserLeaveTypeCurrYear( $empInfo['userID'], $leaveTypes );

                foreach( $leaveTypes as $type ) {
                    /*if( $type['ltID'] != 41 ) {
                        continue;
                    }*/

                    $balInfo = $LeaveBalanceModel->getByltIDUserID( $type['ltID'], $empInfo['userID'] );
                    $carryOver = 0;

                    if( !$balInfo && $type['unused'] == 'carry' && $type['cPeriod'] > 0 && $type['cPeriodType'] ) {
                        // No balance for current year detected, already next year!
                        $lastBalInfo = $LeaveBalanceModel->getByltIDUserID( $type['ltID'], $empInfo['userID'], (date('Y')-1) );

                        if( $lastBalInfo['balance'] > $type['cPeriod'] ) {
                            $carryOver = $type['cPeriod'];
                        }
                        else {
                            $carryOver = $lastBalInfo['balance'];
                        }
                    }
                    $totalApplied = isset( $type['totalApplied'] ) ? $type['totalApplied'] : 0;
                    $totalLeaves  = isset( $type['totalLeaves']  ) ? $type['totalLeaves']  : 0;
                    $totalLeaves += $carryOver;

                    $info = array( );
                    $info['totalLeaves'] = (float)$totalLeaves;
                    $info['totalApplied'] = (float)$totalApplied;
                    $info['balance'] = $info['totalLeaves']-$info['totalApplied'];

                    if( !isset( $balInfo['elbID'] ) ) {
                        $info['ltID'] = $type['ltID'];
                        $info['userID'] = (int)$empInfo['userID'];
                        $info['year'] = date('Y');
                        //var_dump($info);
                        $this->LeaveBalance->insert('employee_leave_bal', $info );
                    }
                    else {
                        $this->LeaveBalance->update('employee_leave_bal', $info,
                            'WHERE ltID = "' . (int)$type['ltID'] . '" AND
                                      userID = "' . (int)$empInfo['userID'] . '"' );
                    }
                }
            }
        }
        echo "End Calculate Leave Balance\n";
    }
}
?>