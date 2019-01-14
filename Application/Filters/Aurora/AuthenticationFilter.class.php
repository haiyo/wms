<?php
namespace Filters\Aurora;
use \Library\Security\Aurora\BruteForce;
use \Library\IO\File, \Library\Http\HttpRequest, \Library\Http\HttpResponse;
use \Library\Security\Aurora\Authenticator;
use \Library\Exception\Aurora\AuthLoginException;
use \Library\Runtime\Registry, \IFilter, \FilterChain;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Sunday, July 29, 2012
 * @version $Id: AuthenticationFilter.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AuthenticationFilter implements IFilter {


    // Properties


    /**
    * AuthenticationFilter Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * Authentication Filter
    * @throws AuthLoginException
    * @return void
    */
    public function doFilter( HttpRequest $Request, HttpResponse $Response, FilterChain $FilterChain ) {
        if( $Request->request( POST, 'auroraForgotPassword' ) ) {
            $FilterChain->doFilter( $Request, $Response );
            return;
        }

        $Registry = Registry::getInstance( );
        File::import( LIB . 'Security/Aurora/Authenticator.dll.php' );
        $Authenticator = new Authenticator( );

        if( $Response->getCode( ) == HttpResponse::HTTP_UNAUTHORIZED ) {
            if( $Request->request( POST, 'auroraLogin' ) ) {
                try {
                    if( $Registry->get( HKEY_LOCAL, 'enableBF' ) ) {
                        File::import( LIB . 'Security/Aurora/BruteForce.dll.php' );
                        $BruteForce = new BruteForce( );
                        if( $BruteForce->isExceeded( ) ) {
                            $Response->setCode( HttpResponse::HTTP_SERVICE_UNAVAILABLE );
                            throw new AuthLoginException( HttpResponse::HTTP_UNAUTHORIZED );
                        }
                    }
                    if( $Authenticator->login( $Request, $Response ) ) {
                        $BruteForce->clearCurrent( );
                    }
                }
                catch( AuthLoginException $e ) {
                    if( $Registry->get( HKEY_LOCAL, 'enableBF' ) ) {
                        $BruteForce->logIP( );
                    }
                    throw new AuthLoginException( HttpResponse::HTTP_UNAUTHORIZED );
                }
            }
            else {
                $Response->setCode( HttpResponse::HTTP_UNAUTHORIZED );
                throw new AuthLoginException( HttpResponse::HTTP_UNAUTHORIZED );
            }
        }
        $Authenticator->getUserModel( )->load( $Registry->get( HKEY_CLASS, 'Session' )->getUserID( ) );
        $Registry->set( HKEY_CLASS, 'Authenticator', $Authenticator );
        $FilterChain->doFilter( $Request, $Response );
    }
}
?>