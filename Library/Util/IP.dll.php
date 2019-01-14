<?php
namespace Library\Util;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Sunday, July 29, 2012
 * @version $Id: IP.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class IP {


    // Properties
    private $ip;


    /**
    * IP Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * Set an IP address (with validation).
    * @return bool
    */
    public function setIP( $ip ) {
        if( filter_var( $ip, FILTER_VALIDATE_IP ) ) {
            $this->ip = $ip;
        }
        else {
            return false;
        }
    }


    /**
    * Returns the raw IP address.
    * @return float
    */
    public function getAddress( ) {
        $this->ip = isset( $_SERVER['HTTP_CLIENT_IP'] ) ? $_SERVER['HTTP_CLIENT_IP'] :
                    isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

        return $this->ip;
    }


    /**
    * Convert and returns IP in integer
    * @return int
    */
    public function getLong( ) {
		if( !$this->ip )
		$this->ip = $this->getAddress( );
        //$this->ip = '175.156.126.41';
		return sprintf( "%u", ip2long( $this->ip ) );
	}


    /**
    * Network ranges can be specified as:
    * 1. Wildcard format:     1.2.3.*
    * 2. CIDR format:         1.2.3/24  OR  1.2.3.4/255.255.255.0
    * 3. Start-End IP format: 1.2.3.0-1.2.3.255
    * @return bool
    */
    public function inRange( $range ) {
        if( !$this->ip )
		$this->ip = $this->getAddress( );
        //$this->ip = '175.156.238.153';

        if( strpos( $range, '/' ) !== false ) {
            // $range is in IP/NETMASK format
            list( $range, $netmask ) = explode( '/', $range, 2 );
            if( strpos( $netmask, '.' ) !== false ) {
                // $netmask is a 255.255.0.0 format
                $netmask = str_replace( '*', '0', $netmask );
                $netmaskDec = ip2long( $netmask );
                return ( ( ip2long( $this->ip ) & $netmaskDec ) == ( ip2long( $range ) & $netmaskDec ) );
            }
            else {
                // $netmask is a CIDR size block
                // fix the range argument
                $x = explode( '.', $range );
                while( count( $x )<4 ) $x[] = '0';
                list( $a, $b, $c, $d ) = $x;
                $range = sprintf( "%u.%u.%u.%u", empty( $a ) ? '0' : $a,
                                                 empty( $b ) ? '0' : $b,
                                                 empty( $c ) ? '0' : $c,
                                                 empty( $d ) ? '0' : $d );
                $rangeDec    = ip2long( $range );
                $ipDec       = ip2long( $this->ip );
                $wildcardDec = pow( 2, ( 32-$netmask ) ) - 1;
                $netmaskDec  = ~ $wildcardDec;
                return ( ( $ipDec & $netmaskDec ) == ( $rangeDec & $netmaskDec ) );
            }
        }
        else {
            // range might be 255.255.*.* or 1.2.3.0-1.2.3.255
            if( strpos( $range, '*' ) !== false ) { // a.b.*.* format
                // Just convert to A-B format by setting * to 0 for A and 255 for B
                $lower = str_replace( '*', '0',   $range );
                $upper = str_replace( '*', '255', $range );
                $range = "$lower-$upper";
            }
            // A-B format
            if( strpos( $range, '-' ) !== false ) {
                list( $lower, $upper ) = explode( '-', $range, 2 );
                $lowerDec = (float)sprintf( "%u",ip2long( $lower ) );
                $upperDec = (float)sprintf( "%u",ip2long( $upper ) );
                $ipDec    = (float)sprintf( "%u",ip2long( $this->ip ) );
                return ( ( $ipDec >= $lowerDec ) && ( $ipDec <= $upperDec ) );
            }
            return false;
        }
    }
}
?>