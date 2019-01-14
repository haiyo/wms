<?php
namespace Filters\Aurora;
use \Library\IO\File, \Library\Http\HttpRequest, \Library\Http\HttpResponse, \Library\Http\IP;
use \Library\Exception\Aurora\AuthLoginException;
use \Library\Runtime\Registry, \IFilter, \FilterChain;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Sunday, July 29, 2012
 * @version $Id: IPRestrictFilter.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class IPRestrictFilter implements IFilter {


    // Properties


    /**
    * IPRestrictFilter Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * IP Filtering
    * @return void
    */
    public function doFilter( HttpRequest $Request, HttpResponse $Response, FilterChain $FilterChain ) {
        $Registry = Registry::getInstance( );
        if( $Registry->get( HKEY_LOCAL, 'enableIP' ) ) {
            if( $Registry->get( HKEY_LOCAL, 'blockCountry' ) ) {
                File::import( LIB . 'Util/IP.dll.php' );
                File::import( DAO . 'Aurora/IP.class.php' );
                $IP    = new IP( );
                $DefIP = new DefIP( );
                $countryInfo = $IP->getCountry( $DefIP->getLong( ) );

                $countries = explode( ',', $Registry->get( HKEY_LOCAL, 'blockCountry' ) );
                if( in_array( $countryInfo['country_code'], $countries ) ) {
                    $Registry->setCookie( 'userID',   '' );
                    $Registry->setCookie( 'sessHash', '' );
                    $Response->setCode( HttpResponse::HTTP_FORBIDDEN );
                    throw( new AuthLoginException( HttpResponse::HTTP_FORBIDDEN ) );
                }
            }
            // NOT IN white list kick them out!
            if( $Registry->get( HKEY_LOCAL, 'ipWhiteList' ) ) {
                if( !$this->inList( $Registry->get( HKEY_LOCAL, 'ipWhiteList' ) ) ) {
                    $Registry->setCookie( 'userID',   '' );
                    $Registry->setCookie( 'sessHash', '' );
                    $Response->setCode( HttpResponse::HTTP_FORBIDDEN );
                    throw( new AuthLoginException( HttpResponse::HTTP_FORBIDDEN ) );
                }
            }
            // IN black list kick them out!
            else if( $Registry->get( HKEY_LOCAL, 'ipBlackList' ) ) {
                if( $this->inList( $Registry->get( HKEY_LOCAL, 'ipBlackList' ) ) ) {
                    $Registry->setCookie( 'userID',   '' );
                    $Registry->setCookie( 'sessHash', '' );
                    $Response->setCode( HttpResponse::HTTP_FORBIDDEN );
                    throw( new AuthLoginException( HttpResponse::HTTP_FORBIDDEN ) );
                }
            }
        }
        $FilterChain->doFilter( $Request, $Response );
    }


    /**
    * IP Filtering
    * @return void
    */
    public function inList( $ruleList ) {
        $list = explode( "\n\r", $ruleList );
        if( is_array( $list ) ) {
            $DefIP = new IP( );

            foreach( $list as $rules ) {
                if( !strstr( $rules, '*' ) && !strstr( $rules, '-' ) &&
                    !strstr( $rules, '/' ) ) {
                    // Match exact
                    if( $DefIP->getAddress( ) == $rules ) {
                        return true;
                    }
                }
                else {
                    // Need more complex range matching
                    if( $DefIP->inRange( $rules ) ) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
}
?>