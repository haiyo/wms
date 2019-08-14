<?php
namespace Markaxis\Employee;

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
            $this->LeaveBalance->setLimit( 0, $limit );
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
}
?>