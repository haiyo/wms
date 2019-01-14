<?php
namespace Aurora;
use \Library\Runtime\Registry as DefRegistry;
use \HttpResponse, \DataStoreHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: Registry.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Registry extends DefRegistry {


    // Database Object
    private $DB;


    /**
    * Aurora Registry Constructor
    * @return void
    */
    protected function __construct( ) {
        parent::__construct( );
	}


    /**
    * Set Data Store Instance.
    * @return void
    */
    public function setDB( DataStoreHelper $DB ) {
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
    * Insert New Entry
    * @return void
    */
    public function insert( ) {
        //
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