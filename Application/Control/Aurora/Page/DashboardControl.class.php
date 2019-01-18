<?php
namespace Aurora\Page;
use \Library\IO\File;
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
        File::import( VIEW . 'Aurora/Page/DashboardView.class.php' );
        $DashboardView = new DashboardView( );
        return $DashboardView->renderMenu( $css );
    }


    /**
     * DashboardControl Main
     * @return void
     */
    public function dashboard( ) {
        $output = Control::getOutputArray( );

        File::import( VIEW . 'Aurora/Page/DashboardView.class.php' );
        $DashboardView = new DashboardView( );
        $DashboardView->printAll( $DashboardView->renderDashboard( $output ) );
    }
}
?>