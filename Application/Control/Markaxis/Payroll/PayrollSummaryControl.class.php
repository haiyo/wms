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
    protected $PayrollSummaryView;


    /**
     * PayrollSummaryControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->PayrollSummaryModel = PayrollSummaryModel::getInstance( );
        $this->PayrollSummaryView = new PayrollSummaryView( );
    }


    /**
     * Render main navigation
     * @return void
     */
    public function processPayroll( $args ) {
        if( isset( $args[1] ) && isset( $args[2] ) ) {
            $PayrollModel = PayrollModel::getInstance( );

            if( $payrollInfo = $PayrollModel->getProcessByDate( $args[2] ) ) {
                $PayrollUserModel = PayrollUserModel::getInstance( );

                if( $payrollUserInfo = $PayrollUserModel->getUserPayroll( $payrollInfo['pID'], $args[1] ) ) {
                    $data = Control::getOutputArray( );
                    echo $this->PayrollSummaryView->renderProcessForm( $payrollUserInfo['puID'], $args[1], $args[2], $data );
                    exit;
                }
            }
        }
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


    /**
     * Render main navigation
     * @return string
     */
    public function deletePayroll( ) {
        $data = Control::getOutputArray( );
        $this->PayrollSummaryModel->deletePayroll( $data );
        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }
}
?>