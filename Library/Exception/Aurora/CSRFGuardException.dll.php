<?php
namespace Library\Exception\Aurora;
use \Library\Exception\Exceptions, \Library\Util\UserAgent;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: CSRFGuardException.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CSRFGuardException extends Exceptions {


    // Properties


    /**
    * CSRFGuardException Constructor
    * @return void
    */
    function __construct( $errMsg ) {
        $UserAgent = new UserAgent( );
        parent::__construct( $errMsg. ' IP: ' . $_SERVER['REMOTE_ADDR'] .
                                ' - ' . gethostbyaddr( $_SERVER['REMOTE_ADDR'] ) );
	}
}
?>