<?php
namespace Markaxis\Employee;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: LeaveBalanceControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveBalanceControl {


    // Properties
    protected $LeaveBalanceModel;


    /**
     * LeaveBalanceControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->LeaveBalanceModel = new LeaveBalanceModel( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function dashboard( ) {
        Control::setOutputArray( array( 'balance' => $this->LeaveBalanceModel->getSidebar( ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function globalInit( ) {
        $EmployeeModel = EmployeeModel::getInstance( );
        $empInfo = $EmployeeModel->getInfo( );
        $data = Control::getOutputArray( );

        if( sizeof( $empInfo ) > 0 && isset( $data['leaveTypes'] ) && is_array( $data['leaveTypes'] ) &&
            sizeof( $data['leaveTypes'] ) > 0 ) {
            $this->LeaveBalanceModel->updateUserBalance( $empInfo['userID'], $data['leaveTypes'] );
        }
    }
}
?>