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


    /**
     * LeaveBalanceControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function dashboard( ) {
        $LeaveBalanceModel = new LeaveBalanceModel( );
        Control::setOutputArray( array( 'balance' => $LeaveBalanceModel->getSidebar( ) ) );
    }
}
?>