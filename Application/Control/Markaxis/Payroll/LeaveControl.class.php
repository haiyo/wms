<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: LeaveControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveControl {


    // Properties
    private $LeaveView;


    /**
     * LeaveControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->LeaveView = new LeaveView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( $this->LeaveView->renderProcessForm( $data) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function viewSaved( ) {
        $this->processPayroll( );
    }
}
?>