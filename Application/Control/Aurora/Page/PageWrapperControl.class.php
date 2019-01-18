<?php
namespace Aurora\Page;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PageWrapperControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PageWrapperControl {


    // Properties


    /**
    * PageWrapperControl Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * PageWrapperControl Main
    * @return void
    */
    public function page( $args ) {
        $PageModel = PageModel::getInstance( );
        $PageView = new PageView( $PageModel );
        Control::setOutputAppend( $PageView->renderPage( $args ) );
        
        $AuroraView = AuroraView::getInstance( );
        $AuroraView->printAll( Control::getOutput( ) );
    }


    /**
    * Save Page Droplets
    * @return void
    */
    public function saveDroplets( ) {
        $post = Control::getRequest( )->request( POST );

        $PageModel = new PageModel( );
        echo $PageModel->saveDroplets( $post['pageURL'][0], $post['droplets'] );
        exit;
    }


    /**
    * Save Page Sorting
    * @return void
    */
    public function saveSorting( ) {
        $post = Control::getRequest( )->request( POST );

        $PageModel = new PageModel( );
        echo $PageModel->saveSorting( $post );
        exit;
    }


    /**
    * Remove Droplet
    * @return void
    */
    public function removeDroplet( ) {
        $post = Control::getRequest( )->request( POST );

        $PageModel = new PageModel( );
        echo $PageModel->removeDroplet( $post['dropletID'] );
        exit;
    }
}
?>