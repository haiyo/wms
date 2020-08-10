<?php
namespace Library\Http;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: HttpRequest.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

define( 'GET',    'GET'    );
define( 'POST',   'POST'   );
define( 'FILES',  'FILES'  );
define( 'COOKIE', 'COOKIE' );
define( 'SERVER', 'SERVER' );

class HttpRequest {


     // Properties
     protected $source;


    /**
    * HttpRequest Constructor
    * @access public
    * @return void
    */
    public function __construct( ) {
        // Remove quotes if auto
        $this->source = array( );
        $this->source[GET]    = $_GET;
        $this->source[POST]   = $_POST;
    	$this->source[COOKIE] = $_COOKIE;
    	$this->source[FILES]  = $_FILES;
    	$this->source[SERVER] = $_SERVER;
    }


    /**
    * Returns clients data
    * @param $source string Where source is one of: GET, POST, FILES...etc
    * @param $key string The attribute name if any
    * @return the value of the source or false otherwise
    */
    public function request( $source, $key=NULL ) {
        if( !is_null( $key ) && isset( $this->source[strtoupper($source)][$key] ) ) {
            return $this->source[strtoupper($source)][$key];
        }
        else if( isset( $this->source[strtoupper($source)][$key] ) &&
                sizeof( $this->source[strtoupper($source)] > 0 ) ) {
            return $this->source[strtoupper($source)];
        }
        else if( is_null( $key ) && isset( $this->source[strtoupper($source)] ) ) {
            return $this->source[strtoupper($source)];
        }
        return false;
    }


    /**
    * Remove all quotes from arrays
    * @param $array mixed
    * @return mixed
    */
    private function santize( $array ) {
    	if( is_array( $array ) ) {
            $data = array( );
            foreach( $array as $k => $v ) {
                $data[$k] = is_array( $v ) ? $this->santize( $v ) : stripslashes( $v );
            }
            return $data;
        }
    }
}
?>