<?php
namespace Filters\Aurora;
use \Library\Http\HttpRequest, \Library\Http\HttpResponse;
use \Aurora\Component\Session;
use \Library\Runtime\Registry, \Library\Interfaces\IFilter, \Library\Util\FilterChain;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Sunday, July 29, 2012
 * @version $Id: SessionFilter.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class SessionFilter implements IFilter {


    // Properties


    /**
    * SessionFilter Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * Session Filtering
    * @return void
    */
    public function doFilter( HttpRequest $Request, HttpResponse $Response, FilterChain $FilterChain ) {
        $Registry = Registry::getInstance( );

        $Session = new Session( );

        if( $Registry->get( HKEY_LOCAL, 'sessTimeout' ) > 0 ) {
            // Search and delete all dead sessions.
            $timeout = ( time( )-$Registry->get( HKEY_LOCAL, 'sessTimeout' ) );
            $Session->deleteExpire( $timeout );
        }
        if( $Session->isFound( ) && $Session->authHash( ) ) {
            $Session->updateSession( );
        }
        else {
            // Continue the Gateway flow to Authentication filter
            $Response->setCode( HttpResponse::HTTP_UNAUTHORIZED );
        }
        $Registry->set( HKEY_CLASS, 'Session', $Session );
        $FilterChain->doFilter( $Request, $Response );
    }
}
?>