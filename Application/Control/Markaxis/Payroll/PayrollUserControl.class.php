<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: PayrollUserControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollUserControl {


    // Properties
    protected $PayrollUserModel;


    /**
     * PayrollUserControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->PayrollUserModel = PayrollUserModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function savePayroll( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( array( 'puID' => $this->PayrollUserModel->savePayroll( $data ) ) );
    }
}
?>