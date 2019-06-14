<?php
namespace Markaxis\Payroll;
use \Markaxis\Employee\EmployeeModel;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: EmployeeControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EmployeeControl {


    // Properties
    private $EmployeeView;


    /**
     * EmployeeControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->EmployeeView = new EmployeeView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( $args ) {
        // Get userID
        if( isset( $args[1] ) ) {
            $EmployeeModel = EmployeeModel::getInstance( );

            if( $empInfo = $EmployeeModel->getFieldByUserID( $args[1], 'salary' ) ) {
                Control::setOutputArray( array( 'salary' => $empInfo['salary'] ) );
                Control::setOutputArray( $this->EmployeeView->renderProcessForm( $args[1] ) );
            }
        }
    }
}
?>