<?php
namespace Aurora\Page;
use \Library\IO\File;
use \Control;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: NotFoundControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NotFoundControl {


    // Properties


    /**
    * NotFoundControl Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
     * DashboardControl Main
     * @return void
     */
    public function notFound( ) {
        File::import( MODEL . 'Aurora/Page/NotFoundModel.class.php' );
        $NotFoundModel = NotFoundModel::getInstance( );

        File::import( VIEW . 'Aurora/Page/NotFoundView.class.php' );
        $NotFoundView = new NotFoundView( $NotFoundModel );
        $NotFoundView->printAll( $NotFoundView->renderPage( ) );
    }
}
?>