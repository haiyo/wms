<?php
namespace Aurora\Page;
use \Library\IO\File;
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
        File::import( MODEL . 'Model.class.php' );
        File::import( MODEL . 'Aurora/Page/PageModel.class.php' );
        $PageModel = PageModel::getInstance( );

        File::import( VIEW . 'Aurora/Page/PageTabView.class.php' );
        $PageTabView = new PageTabView( $PageModel, $args );
        Control::setOutputAppend( $PageTabView->renderTab( ) );
    }
}
?>