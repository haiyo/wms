<?php
namespace Aurora\Page;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: DashboardControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DashboardControl {


    // Properties
    private $DashboardView;


    /**
    * DashboardControl Constructor
    * @return void
    */
    function __construct( ) {
        $this->DashboardView = new DashboardView( );
    }


    /**
    * DashboardControl Main
    * @return mixed
    */
    public function getMenu( $css ) {
        return $this->DashboardView->renderMenu( $css );
    }


    /**
     * DashboardControl Main
     * @return void
     */
    public function dashboard( ) {
        $output = Control::getOutputArray( );
        $this->DashboardView->renderDashboard( $output );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getPendingAction( ) {
        $output = Control::getOutputArray( );

        $vars = array( );
        $vars['bool'] = 0;

        if( isset( $output['pending'] ) ) {
            $vars['bool'] = 1;
            $vars['data'] = $this->DashboardView->renderPendingAction( $output['pending'] );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getRequest( ) {
        $output = Control::getOutputArray( );
        $vars = array( );
        $vars['bool'] = 0;

        if( isset( $output['request'] ) && $output['request'] ) {
            $vars['bool'] = 1;
            $vars['data'] = $this->DashboardView->renderRequest( $output['request'] );
        }
        echo json_encode( $vars );
        exit;
    }
}
?>