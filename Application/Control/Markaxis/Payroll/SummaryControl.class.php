<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: SummaryControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class SummaryControl {


    // Properties
    protected $SummaryModel;
    protected $SummaryView;


    /**
     * SummaryControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->SummaryModel = SummaryModel::getInstance( );
        $this->SummaryView = new SummaryView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getAllProcessed( $args ) {
        // processDate && officeID
        if( isset( $args[1] ) && isset( $args[2] ) ) {
            $post = Control::getRequest( )->request( POST );
            echo json_encode( $this->SummaryModel->getResults( $post, $args[1], $args[2] ) );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getChart( ) {
        $vars = array( );
        $post = Control::getRequest( )->request( POST );

        if( isset( $post['date'] ) ) {
            Control::setOutputArrayAppend( array( 'data' => $this->SummaryModel->getCountByDate( $post['date'] ) ) );

            $output = Control::getOutputArray( );
            $vars['bool'] = 1;
            $vars['data'] = $output['data'];
            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( ) {
        $data = Control::getOutputArray( );
        echo $this->SummaryView->renderProcessForm( $data );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function reprocessPayroll( ) {
        $data = Control::getOutputArray( );
        $vars = array( );
        $vars['bool'] = 1;
        $vars['data'] = $data;
        $vars['summary'] = $this->SummaryView->renderProcessSummary( $data );
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function viewSaved( ) {
        $data = Control::getOutputArray( );
        echo $this->SummaryView->renderSavedForm( $data );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function savePayroll( ) {
        $data = Control::getOutputArray( );
        $this->SummaryModel->savePayroll( $data );
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
        $this->SummaryModel->deletePayroll( $data );
        $vars['data'] = $data;
        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }
}
?>