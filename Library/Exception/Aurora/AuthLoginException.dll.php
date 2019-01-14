<?php
namespace Library\Exception\Aurora;
use \Library\Http\HttpRequest, \Library\Http\HttpResponse, \Library\Util\UserAgent;
use \Library\Exception\Exceptions;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: AuthLoginException.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AuthLoginException extends Exceptions {


    /**
    * AuthLoginException Constructor
    * @return void
    */
    function __construct( $errCode, HttpRequest $Request=NULL ) {
        $UserAgent = new UserAgent( );

        if( $errCode == HttpResponse::HTTP_EXPECTATION_FAILED ) {
            $post = $Request->request( POST );
            if( isset( $post['login'] ) ) unset( $post['login'] );
            parent::__construct( 'Login failed from user IP: ' . $_SERVER['REMOTE_ADDR'] .
                                ' - ' . gethostbyaddr( $_SERVER['REMOTE_ADDR'] ) . '. Dump info: ' .
                                implode( ',', $post ) );
        }
        if( $errCode == HttpResponse::HTTP_UNAUTHORIZED ) {
            parent::__construct( 'Unauthorized from user IP: ' . $_SERVER['REMOTE_ADDR'] .
                                ' - ' . gethostbyaddr( $_SERVER['REMOTE_ADDR'] ) );
        }
    }
}
?>