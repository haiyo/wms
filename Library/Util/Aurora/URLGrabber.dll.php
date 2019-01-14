<?php
namespace Aurora;
use \URLSanitizer, \Validator, \ValidatorException;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: URLGrabber.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class URLGrabber {


    // Properties
    protected $url;
    protected $info;


    /**
    * URLGrabber Constructor
    * @return void
    */
    function __construct( $url ) {
        $this->url  = $url;
        $this->info = array( );
	}


   /**
   * Get a web file (HTML, XHTML, XML, image, etc.) from a URL.  Return an
   * array containing the HTTP server response header fields and content.
   * @return mixed
   */
   public function getURLPage( ) {
       $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "gzip",   // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLOPT_COOKIEJAR      => 'my_cookies.txt',
            CURLOPT_COOKIEFILE     => 'my_cookies.txt',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER     => array( 'Content-Type', 'text/html;charset=utf-8' ),
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534.24 (KHTML, like Gecko) Chrome/11.0.696.71 Safari/534.24',
       );

       $ch = curl_init( $this->url );
       curl_setopt_array( $ch, $options );
       $content = curl_exec( $ch );
       $err     = curl_errno( $ch );
       $errmsg  = curl_error( $ch );
       $header  = curl_getinfo( $ch );
       curl_close( $ch );

       $header['errno']   = $err;
       $header['errmsg']  = $errmsg;
       $header['content'] = $content;
       return $header;
    }


    /**
   * Convert relative URL to absolute
   * @return str
   */
    public function rel2abs( $rel, $base ) {
        // return if already absolute URL
        if( parse_url( $rel, PHP_URL_SCHEME ) != '' ) return $rel;
        if( isset( $rel[0] ) ) {
            if( $rel[0]=='#' || $rel[0]=='?' ) return $base.$rel;
        }

        // parse base URL and convert to local variables: $scheme, $host, $path
        //extract( parse_url( $base ) );
        if( !preg_match( '/^(\w+:\/\/)/', $base ) ) {
            $base = 'http://' . $base;
        }
        $parseURL = parse_url( $base );
        $scheme = isset( $parseURL['scheme'] ) ? $parseURL['scheme'] : 'http';
        $host   = isset( $parseURL['host'] ) ? $parseURL['host'] : '';
        $path   = isset( $parseURL['path'] ) ? $parseURL['path'] : '';

        // remove non-directory element from path
        $path = preg_replace( '#/[^/]*$#', '', $path );

        // destroy path if relative url points to root
        if( isset( $rel[0] ) ) {
            if( $rel[0] == '/' ) $path = '';
        }
        // dirty absolute URL
        $abs = "$host$path/$rel";

        // replace '//' or '/./' or '/foo/../' with '/'
        $re = array('#(/\.?/)#', '#/(?!\.\.)[^/]+/\.\./#');
        for($n=1; $n>0; $abs=preg_replace($re, '/', $abs, -1, $n)) {}
        return $scheme.'://'.$abs;
    }
}
?>