<?php
namespace Library\Http;
use \Library\IO\File, \Library\Util\XML;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: Dispatcher.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Dispatcher {


    // Properties
    protected $map;
    protected $dir;

    protected $call;
    protected $event;
    protected $args;

    
    /**
    * Dispatcher Constructor
    * @return void
    */
    function __construct( ) {
        $this->map = array( );
        $this->dir = array( );
	}


    /**
    * Return Calling Directory
    * @return str
    */
    public function getDir( ) {
        return $this->dir;
	}


    /**
    * Return Call ~ ring ~ ring ~ :(
    * @return str
    */
    public function getCall( ) {
        return $this->call;
	}


    /**
    * Return Event Name
    * @return str
    */
    public function getEvent( ) {
        return $this->event;
	}


    /**
    * Return Arguments
    * @return str
    */
    public function getArgs( ) {
        return $this->args;
	}


    /**
    * Load Mapping to Directory from XML Config
    * @return void
    */
    public function setMapping( $xmlconfig ) {
        try {
            // Start loading XML for Filters information
            File::import( LIB . 'Util/XML.dll.php' );
            $XML = new XML( );
            $XMLElement = $XML->load( $xmlconfig );
            $sizeof = sizeof( $XMLElement->path );

            for( $i=0; $i<$sizeof; $i++ ) {
                $path = (string)$XMLElement->path[$i]->attributes( );
                $this->path[$path] = (string)$XMLElement->path[$i];
            }
        }
        catch( FileNotFoundException $e ) {
            $e->record( );
        }
    }


    /**
    * Monitor URL Parameter
    * @return bool
    */
    public function monitor( $pathInfo, $args=NULL ) {
        // Default to IndexController if no Controller is found.
        $pathInfo = $pathInfo == '' ? 'index' : $pathInfo;
        $pathInfo = substr( $pathInfo, -1 ) == '/' ? substr( $pathInfo, 0, -1 ) : $pathInfo;
        $pathInfo = explode( '/', $pathInfo );

        foreach( $this->path as $path => $namespace ) {
            if( $pathInfo[0] != 'admin' && $path == 'index' ) {
                $this->call = $namespace;
                $this->args = $pathInfo;
                $this->dispatch( );
                return true;
            }
            else {
                if( preg_match( "|{$path}(.*)$|i", $pathInfo[0] ) ) {
                    $this->call = $namespace;

                    if( !$args ) {
                        array_shift($pathInfo);
                        $this->args = $pathInfo;
                    }
                    else {
                        $this->args = $args;
                    }
                    $this->dispatch( );
                    return true;
                }
            }
        }
    }


    /**
    * Dispatch Call to Controller
    * @return void
    */
    private function dispatch( ) {
        try {
            File::import( CONTROL . 'Control.class.php' );
            File::import( CONTROL . $this->call . '.class.php' );

            $namespace = explode( '/', $this->call );
            $className = $namespace[0] . '\\' . basename( $this->call );

            $Object = new $className( );
            $Object->init( $this->args );
        }
        catch( FileNotFoundException $e ) {
            $e->record( );
            HttpResponse::sendHeader( HttpResponse::HTTP_INTERNAL_SERVER_ERROR );
        }
    }
}
?>