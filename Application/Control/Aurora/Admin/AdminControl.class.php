<?php
namespace Aurora\Admin;
use \Library\IO\File;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: ControlPanelControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AdminControl {


    // Properties


    /**
    * AdminControl Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * Render main navigation
    * @return str
    */
    public function getMenu( $css ) {
        File::import( VIEW . 'Aurora/Admin/AdminView.class.php' );
        $AdminView = new AdminView( );
        return $AdminView->renderMenu( $css );
    }


    /**
    * Render main navigation
    * @return str
    */
    public function getSysMenu( $css ) {
        File::import( VIEW . 'Aurora/Admin/AdminView.class.php' );
        $AdminView = new AdminView( );
        return $AdminView->renderSysMenu( $css );
    }
}
?>