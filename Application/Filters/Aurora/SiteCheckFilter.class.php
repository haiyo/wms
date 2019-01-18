<?php
namespace Filters\Aurora;
use \Library\Http\HttpRequest, \Library\Http\HttpResponse;
use \Library\Runtime\Registry, \Library\Interfaces\IFilter, \Library\Util\FilterChain;
use \Library\Exception\RegistryException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: SiteCheckFilter.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class SiteCheckFilter implements IFilter {


    // Properties


    /**
    * SiteCheckFilter Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * Check Current Site Toggle Filtering
    * @throws SiteCheckException
    * @return void
    */
    public function doFilter( HttpRequest $Request, HttpResponse $Response, FilterChain $FilterChain ) {
        $Registry = Registry::getInstance();

        try {
            $Authorization = $Registry->get( HKEY_CLASS, 'Authorization' );

            if( $Registry->get(HKEY_LOCAL, 'maintenance') && !$Authorization->isAdmin( ) ) {
                $Response->setCode(HttpResponse::HTTP_SERVICE_UNAVAILABLE);
                throw( new SiteCheckException('Website is currently turned off.') );
            }
        }
        catch( RegistryException $e ) {
            if( $Registry->get(HKEY_LOCAL, 'maintenance') ) {
                $Response->setCode(HttpResponse::HTTP_SERVICE_UNAVAILABLE);
                throw( new SiteCheckException('Website is currently turned off.') );
            }
        }
        $FilterChain->doFilter( $Request, $Response );
    }
}
?>