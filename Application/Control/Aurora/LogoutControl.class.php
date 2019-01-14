<?php
namespace Aurora;
use \Library\Runtime\Registry, \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LogoutControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LogoutControl {


    // Properties
    protected $Registry;


    /**
    * LogoutControl Constructor
    * @return void
    */
    function __construct( ) {
        $this->Registry = Registry::getInstance( );
	}


    /**
    * Logout
    * @return void
    */
    public function logout( ) {
        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $Authenticator->logout( Control::getResponse( ) );
        header( 'location: ' . ROOT_URL . 'admin/' );
    }
}
?>