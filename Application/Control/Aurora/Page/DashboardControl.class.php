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


    /**
    * DashboardControl Constructor
    * @return void
    */
    function __construct( ) {
        //
    }


    /**
    * DashboardControl Main
    * @return void
    */
    public function getMenu( $css ) {
        $DashboardView = new DashboardView( );
        return $DashboardView->renderMenu( $css );
    }


    /**
     * DashboardControl Main
     * @return void
     */
    public function dashboard( ) {
        $output = Control::getOutputArray( );

        $DashboardView = new DashboardView( );
        $DashboardView->printAll( $DashboardView->renderDashboard( $output ) );
    }


    /**
     * DashboardControl Main
     * @return void
     */
    public function test( ) {
        $info['notifyUserIDs'] = array( 33 );
        $info['notifyEvent'] = 'chatMessage';
        $info['notifyType'] = 'normal';
        $vars['data'] = $info;
        echo json_encode( $vars );
        exit;
    }
}
?>