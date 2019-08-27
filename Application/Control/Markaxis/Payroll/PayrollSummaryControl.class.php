<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: PayrollSummaryControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollSummaryControl {


    // Properties
    protected $PayrollSummaryModel;


    /**
     * PayrollSummaryControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->PayrollSummaryModel = PayrollSummaryModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function savePayroll( ) {
        $data = Control::getOutputArray( );
        $this->PayrollSummaryModel->savePayroll( $data );
        $vars['data'] = $data;
        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }
}
?>