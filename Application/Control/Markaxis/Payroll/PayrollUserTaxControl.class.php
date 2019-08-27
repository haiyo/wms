<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: PayrollUserTaxControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollUserTaxControl {


    // Properties
    protected $PayrollUserTaxModel;


    /**
     * PayrollUserTaxControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->PayrollUserTaxModel = PayrollUserTaxModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function savePayroll( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( $this->PayrollUserTaxModel->savePayroll( $data ) );
    }
}
?>