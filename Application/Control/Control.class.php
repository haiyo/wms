<?php
use \Library\Http\HttpRequest, \Library\Http\HttpResponse;
use \Library\Runtime\Registry;
use \Library\Exception\RegistryException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, July 4th, 2012
 * @version $Id: Control.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Control {


    // Properties
    protected $Registry;

    protected static $HttpRequest;
    protected static $HttpResponse;

    private static $output;
    private static $outputArray;
    private static $saveState;
    private static $postData;

    
    /**
    * Controller Constructor
    * @return void
    */
    function __construct( ) {
        self::$HttpRequest  = new HttpRequest( );
        self::$HttpResponse = new HttpResponse( );

        self::$outputArray = array( );
        self::$saveState   = array( );
	}


    /**
     * Return HttpRequest
     * @return mixed
     */
    public static function hasPermission( $namespace, $action ) {
        $Registry = Registry::getInstance( );
        $Authorization = $Registry->get( HKEY_CLASS, 'Authorization' );

        if( $Authorization->hasPermission( $namespace, $action ) ) {
            return true;
        }
        return false;
    }


    /**
    * Return HttpRequest
    * @return mixed
    */
    public static function getRequest( ) {
        return self::$HttpRequest;
    }


    /**
    * Return HttpRequest
    * @return mixed
    */
    public static function getResponse( ) {
        return self::$HttpResponse;
    }


    /**
    * Return Output
    * @return string
    */
    public static function getOutput( ) {
        return self::$output;
    }


    /**
    * Return Output from Array
    * @return mixed
    */
    public static function getOutputArray( $key='' ) {
        if( $key && isset( self::$outputArray[$key] ) ) {
            return self::$outputArray[$key];
        }
        return self::$outputArray;
    }


    /**
    * Set Output
    * @return void
    */
    public static function setOutput( $output ) {
        self::$output = $output;
    }


    /**
    * Set Output Append
    * @return void
    */
    public static function setOutputAppend( $output ) {
        self::$output .= $output;
    }


    /**
    * Set Output to Array by Append
    * @return void
    */
    public static function setOutputArray( $array ) {
        if( is_array( $array ) ) {
            foreach( $array as $key => $value ) {
                self::$outputArray[$key] = $array[$key];
            }
        }
    }


    /**
    * Set Output to Array by Append
    * @return void
    */
    public static function setOutputArrayAppend( $array ) {
        if( sizeof( self::$outputArray ) == 0 ) {
            self::$outputArray = $array;
        }
        else {
            $outputArray = self::$outputArray;
            foreach( $outputArray as $key => $value ) {
                if( isset( $array[$key] ) && $value ) {
                    if( !is_array( $value )) {
                        self::$outputArray[$key] = $value . $array[$key];
                    }
                    else {
                        self::$outputArray[$key] = array_merge_recursive( $value, $array[$key] );
                    }
                    unset( $array[$key] );
                }
            }
            // Check if we have assigned/cleared all values from $array.
            // If it isn't so, assign the "leftover" as new key(s)
            if( sizeof( $array ) > 0 ) {
                foreach( $array as $key => $value ) {
                    self::$outputArray[$key] = $value;
                }
            }
        }
    }


    /**
     * Set Info
     * @return mixed
     */
    public static function getDecodedArray( $info ) {
        if( is_array( $info ) ) {
            foreach( $info as $key => $value ) {
                if( !is_array( $value ) ) {
                    $info[$key] = urldecode( $value );
                }
                else {
                    $info[$key] = self::getDecodedArray( $value );
                }
            }
            return $info;
        }
        return false;
    }


    /**
    * Set Output
    * @return void
    */
    public static function setSaveState( $data ) {
        self::$saveState = array_merge( self::$saveState, $data );
    }


    /**
    * Return Save State
    * @return mixed
    */
    public static function getSaveState( ) {
        return self::$saveState;
    }
    
    
    /**
    * Set Post Data
    * @return void
    */
    public static function setPostData( $data ) {
        self::$postData = $data;
    }
    
    
    /**
    * Get Post Data
    * @return array
    */
    public static function getPostData( ) {
        return self::$postData;
    }


    /**
    * Setup Default Registry
    * @return void
    */
    public function initRegistry( ) {
        // Load Registry Table
        $this->Registry = Registry::getInstance( );
    }
}
?>