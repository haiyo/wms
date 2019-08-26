<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: PayrollLevyControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollLevyControl {


    // Properties
    protected $PayrollLevyModel;


    /**
     * PayrollUserControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->PayrollLevyModel = PayrollLevyModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function savePayroll( ) {
        $data = Control::getOutputArray( );
        $this->PayrollLevyModel->savePayroll( $data );
    }
}
?>