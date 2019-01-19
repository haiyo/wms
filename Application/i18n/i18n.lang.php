<?php
use \Library\IO\File;
use \Library\Util\XML;
use \Library\Exception\FileNotFoundException;
use \Library\Exception\InterfaceException;


/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: Locale.lang.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class i18n {

    
    // Properties
    protected $languages;
    protected $userLang;
    protected $loaded;


    /**
    * i18n Constructor
    * @return void
    */
    function __construct( $xmlconfig ) {
        $this->languages = array( );
        $this->loaded    = array( );
        $this->userLang  = 'en_us';
        $this->loadConfig( $xmlconfig );
    }


    /**
    * Load Available Languages from XML Config
    * @return voids
    */
    private function loadConfig( $xmlconfig ) {
        try {
            // Start loading XML for Filters information
            $XML = new XML( );
            $XMLElement = $XML->load( XML . $xmlconfig );
            $sizeof = sizeof( $XMLElement->language );

            for( $i=0; $i<$sizeof; $i++ ) {
                $attr = (string)$XMLElement->language[$i]->attributes( );
                $this->languages[$attr] = (string)$XMLElement->language[$i];
            }
        }
        catch( FileNotFoundException $e ) {
            $e->record( );
        }
    }

    
    /**
    * Return the list of available languages loaded.
    * @return mixed
    */
    public function getLanguages( ) {
        return $this->languages;
    }
    
    
    /**
    * Get user lang preference
    * @return str
    */
    public function getUserLang( ) {
        return $this->userLang;
    }


    /**
    * Set user lang preference
    * @return bool
    */
    public function setUserLang( $lang ) {
        if( isset( $this->languages[$lang] ) ) {
            $this->userLang = $lang;
            return true;
        }
        return false;
    }
    
    
    /**
    * Return loaded language files
    * @return mixed
    */
    public function getLoaded( ) {
        return $this->loaded;
    }

    
    /**
    * Load language and set to cache
    * @throws FileNotFoundException
    * @return obj
    */
    public function loadLanguage( $langFile ) {
        if( !isset( $this->loaded[$langFile] ) ) {
            $resFile = LANG . $this->userLang . '/Resource.lang.php';
            $file    = LANG . $this->userLang . '/' . $langFile . '.lang.php';

            if( is_file( $resFile ) && is_file( $file ) ) {
                File::import( $resFile );
                File::import( $file );

                //$namespace = explode( '/', $langFile );
                $namespace = str_replace( '/', '\\', $langFile );
                $className = $namespace;// . '\\' . basename( $langFile );
                $className = new $className;

                if( !( $className instanceof Resource ) ) {
                    throw( new InterfaceException( 'Language file ' . $langFile . ' must 
                                                    be an instance of Resource.' ) );
                }
                if( !( $className instanceof ResBundle ) ) {
                    throw( new InterfaceException( 'Language file ' . $langFile . ' must
                                                    be an instance of Resbundle.' ) );
                }
                $this->loaded[$langFile] = $className;
            }
            else {
                throw( new FileNotFoundException( 'Language file not found: ' . $langFile . '.lang.php in ' .
                                                   LANG . $this->userLang . '/ folder.' ) );
            }
        }
        return $this->loaded[$langFile];
    }
}
?>