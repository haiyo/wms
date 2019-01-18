<?php
namespace Aurora;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, July 4th, 2012
 * @version $Id: LoginControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LoginControl {


    // Properties


    /**
    * LoginControl Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * Display login
    * @return void
    */
    public function login( ) {
        $LoginView = new LoginView( );
        $LoginView->printAll( $LoginView->renderLogin( ) );
    }
}
?>