<?php
namespace Filters\Aurora;
use \Library\Http\HttpRequest, \Library\Http\HttpResponse;
use \Library\Security\Aurora\CSRFGuard;
use \Library\Interfaces\IFilter, \Library\Util\FilterChain;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: CSRFGuardFilter.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CSRFGuardFilter implements IFilter {


    // Properties


    /**
    * FirewallFilter Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * CSRF Guard Filtering
    * @return void
    */
    public function doFilter( HttpRequest $Request, HttpResponse $Response, FilterChain $FilterChain ) {
        try {
            $CSRFGuard = new CSRFGuard( );
            $CSRFGuard->init( $Request, $Response );
        }
        catch( CSRFGuardException $e ) {
            die( $e->record( ) );
        }
        $FilterChain->doFilter( $Request, $Response );
    }
}
?>