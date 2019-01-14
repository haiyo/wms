<?php
namespace Filters\Aurora;
use \Library\IO\File, \Library\Http\HttpRequest, \Library\Http\HttpResponse;
use \Library\Runtime\Registry, \IFilter, \FilterChain;
use \i18n;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: i18nFilter.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class i18nFilter implements IFilter {


    // Properties


    /**
    * i18nFilter Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * Detect Localization Filtering
    * @return void
    */
    public function doFilter( HttpRequest $Request, HttpResponse $Response, FilterChain $FilterChain ) {
        $Registry = Registry::getInstance( );

        File::import( LANG . 'i18n.dll.php' );
        $i18n = new i18n('Aurora/languages.xml');

        if( $Request->request( GET, 'lang' ) ) {
            if( $i18n->setUserLang( $Request->request( GET, 'lang' ) ) ) {
                $Registry->setCookie( 'lang', $Request->request( GET, 'lang' ), time( )+60*60*24*30 );
            }
        }
        else if( $Request->request( COOKIE, 'lang' ) ) {
            $i18n->setUserLang( $Request->request( COOKIE, 'lang' ) );
        }
        else {
            // Set system default language
            $i18n->setUserLang( $Registry->get( HKEY_LOCAL, 'language' ) );
        }

        $Registry->set( HKEY_CLASS, 'i18n', $i18n );
        $FilterChain->doFilter( $Request, $Response );
    }
}
?>