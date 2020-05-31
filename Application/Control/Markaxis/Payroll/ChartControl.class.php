<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: ChartControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ChartControl {


    // Properties
    protected $ChartModel;


    /**
     * ChartControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->ChartModel = ChartModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getChart( ) {
        $vars = array( );
        $post = Control::getRequest( )->request( POST );

        if( isset( $post['date'] ) ) {
            Control::setOutputArrayAppend( array( 'data' => $this->ChartModel->getChart( $post['date'] ) ) );

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
    public function getChartee( ) {
        $output = Control::getOutputArray( );
        $vars = array( );
        $vars['bool'] = 0;

        if( isset( $output['data'] ) ) {
            $vars['bool'] = 1;
            $vars['data'] = $output['data'];
        }
        echo json_encode( $vars );
        exit;

        $post = Control::getRequest( )->request( POST );

        if( isset( $post['date'] ) && $vars['data'] = $this->PayrollChartModel->getChart( $post['date'] ) ) {
            $vars['bool'] = 1;
        }
        else {
            $vars['bool'] = 0;
        }
        echo json_encode( $vars );
        exit;
    }
}
?>