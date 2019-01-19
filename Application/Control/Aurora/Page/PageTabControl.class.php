<?php
namespace Aurora\Page;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PageTabControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PageTabControl {


    // Properties


    /**
    * PageTabControl Constructor
    * @return void
    */
    function __construct( ) {
        //
    }


    /**
    * Navigation Controller Main
    * @return void
    */
    public function page( $args ) {
        $PageModel = PageModel::getInstance( );

        $PageTabView = new PageTabView( $PageModel, $args );
        Control::setOutputAppend( $PageTabView->renderTab( ) );
    }
}
?>