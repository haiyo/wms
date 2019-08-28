<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: PayrollContributionControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollContributionControl {


    // Properties
    protected $PayrollContributionModel;


    /**
     * PayrollContributionControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->PayrollContributionModel = PayrollContributionModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function savePayroll( ) {
        $data = Control::getOutputArray( );
        $this->PayrollContributionModel->savePayroll( $data );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deletePayroll( ) {
        $data = Control::getOutputArray( );
        $this->PayrollContributionModel->deletePayroll( $data );
    }
}
?>