<?php
namespace Library\Runtime;
use \Library\Http\HttpResponse;
use \Library\Helper\SingletonHelper;
use \Library\Exception\RegistryException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: Registry.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

define( 'HKEY_USER',  'HKEY_USER'  );
define( 'HKEY_LOCAL', 'HKEY_LOCAL' );
define( 'HKEY_CLASS', 'HKEY_CLASS' );
define( 'HKEY_DYNAM', 'HKEY_DYNAM' );

class Registry extends SingletonHelper {


    /**
    * HKEY_USER Keybox
    * Contains configuration information particular to the user who is
    * currently logged on.
    * @access private
    * @var string
    */
    private $HKEY_USER;


    /**
    * HKEY_LOCAL Keybox
    * Contains configuration information particular to the application.
    * @access private
    * @var string
    */
    private $HKEY_LOCAL;


    /**
    * HKEY_CLASS Keybox
    * Contains object handlers for other class usage
    * @access private
    * @var string
    */
    private $HKEY_CLASS;


    /**
    * HKEY_DYNAM Keybox
    * This key contains dynamic information about plug-n-play modules.
    * @access private
    * @var string
    */
    private $HKEY_DYNAM;


    private $DB;


    /**
    * Registry Constructor
    * It is private in order to ensure the Singleton pattern behavior.
    * @access private - Singleton
    * @return void
    */
    protected function __construct( ) {
        $this->HKEY_USER  = array( );
        $this->HKEY_LOCAL = array( );
        $this->HKEY_CLASS = array( );
        $this->HKEY_DYNAM = array( );
	}


    /**
    * Get Key From Registry
    * @param $keybox string
    * @param $keyname string
    * @access public
    * @return mixed
    */
    public function get( $keybox, $keyname=NULL ) {
        if( !is_null( $keyname ) ) {
            if( !isset( $this->{$keybox}[$keyname] ) ) {
                throw new RegistryException( 'Registry key not found: ' . $keyname .
                                            ' from ' . RegistryException::getCaller( ) );
            }
            return $this->{$keybox}[$keyname];
        }
        return $this->{$keybox};
    }


    /**
    * Bind to registry
    * @param $keybox string:~ Which keybox to register
    * @param $handle object:~ Object handler
    * @access public
    * @return mxied
    */
    public function set( $keybox, $keyname, $keyvalue ) {
        if( !isset( $this->{$keybox}[$keyname] ) ) {
            // NOTE: PHP 5 treats NULL value as unset! Sunday 23rd Jan 2011
            if( is_null( $keyvalue ) ) {
                $keyvalue = '';
            }
            return $this->{$keybox}[$keyname] = $keyvalue;
        }
        else if( is_array( $this->{$keybox}[$keyname] ) && is_array( $keyvalue ) ) {
            // Append to existing if array (Updated: Thursday, March 16, 2006)
            return $this->{$keybox}[$keyname] = array_merge( $this->{$keybox}[$keyname], $keyvalue );
        }
        else {
            // Performs overwrite.
            $this->{$keybox}[$keyname] = $keyvalue;
        }
    }


    /**
     * Set Data Store Instance.
     * @return void
     */
    public function setDB( \Library\Helper\DataStoreHelper $DB ) {
        $this->DB = $DB;
        $this->set( HKEY_CLASS, 'DB', $DB );
    }


    /**
     * Provide wrapper method to set dedicated cookie for Aurora usage. This way
     * we don't need other classes to bother with cookiePath and cookieDomain.
     * @return void
     */
    public function setCookie( $name, $value, $time=0 ) {
        $cookiePath   = $this->get( HKEY_LOCAL, 'cookiePath' );
        $cookieDomain = $this->get( HKEY_LOCAL, 'cookieDomain' );

        $HttpResponse = new HttpResponse( );
        $HttpResponse->setCookie( $name, $value, $time, $cookiePath, $cookieDomain );
    }


    /**
     * Load Application Settings from Registry table.
     * @return void
     */
    public function loadRegistry( ) {
        $sql = $this->DB->select( 'SELECT * FROM registry', __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $this->set( HKEY_LOCAL, $row['name'], $row['value'] );
            }
            define( 'ROOT_URL', $this->get( HKEY_LOCAL, 'protocol' ) .
                $this->get( HKEY_LOCAL, 'domain' ) );

            date_default_timezone_set( $this->get( HKEY_LOCAL, 'timezone' ) );
        }
    }


    /**
     * Update Settings
     * @return void
     */
    public function update( $name, $value ) {
        $this->DB->update( 'UPDATE registry SET value = "' . addslashes( $value ) . '"
                            WHERE name = "' . addslashes( $name ) . '"',
            __FILE__, __LINE__ );
    }
}
?>