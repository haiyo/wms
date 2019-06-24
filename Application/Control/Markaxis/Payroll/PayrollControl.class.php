<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: PayrollControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollControl {


    // Properties
    protected $PayrollModel;
    protected $PayrollView;


    /**
     * PayrollControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->PayrollModel = PayrollModel::getInstance( );
        $this->PayrollView = new PayrollView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function overview( ) {
        $this->PayrollView->printAll( $this->PayrollView->renderOverview( ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function slips( ) {
        $this->PayrollView->printAll( $this->PayrollView->renderSlips( ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getProcessPass( ) {
        $vars = array( );
        $post = Control::getRequest( )->request( POST );

        if( $this->PayrollModel->allowProcessPass( $post ) ) {
            $vars['bool'] = 1;
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->PayrollModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
 * Render main navigation
 * @return string
 */
    public function process( $args ) {
        if( isset( $args[1] ) ) {
            $this->PayrollView->printAll( $this->PayrollView->renderProcess( $args[1] ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( $args ) {
        if( isset( $args[1] ) && isset( $args[2] ) ) {
            $data = Control::getOutputArray( );
            echo $this->PayrollView->renderProcessForm( $args[1], $args[2], $data );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function reProcessPayroll( ) {
        $data = Control::getOutputArray( );
        $vars = array( );
        $vars['bool'] = 1;
        $vars['data'] = $data;
        $vars['summary'] = $this->PayrollView->renderProcessSummary( $data );
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function settings( ) {
        $output = Control::getOutputArray( );
        $this->PayrollView->printAll( $this->PayrollView->renderSettings( $output['form'] ) );
    }
}
?>