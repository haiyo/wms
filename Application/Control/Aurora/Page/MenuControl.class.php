<?php
namespace Aurora\Page;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: MenuControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
class MenuControl {


    // Properties


    /**
    * MenuControl Constructor
    * @return void
    */
    function __construct( ) {
        //
    }


    /**
    * Page Controller Main
    * @return void
    */
    public function page( $args ) {
        $NavigationModel = new NavigationModel( );
        $NavigationView = new NavigationView( $NavigationModel, $args );
        Control::setOutput( $NavigationView->renderAcctHeader( ) );
    }
}
?>