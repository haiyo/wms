<?php
use \Library\Util\BenchmarkTimer;
use \Library\Http\HttpRequest, Library\Http\Dispatcher;
use \Library\Exception\ErrorHandlerException, \Library\Exception\Exceptions;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, July 4th, 2012
 * @version $Id: Application.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
class Application {


    // Properties


    /**
    * Application Constructor
    * The main core application settings and classes will be register here.
    * @return void
    */
    function __construct( ) {
        // Load essential files
        require_once( LIB . 'IO/File.dll.php' );
        require_once( LIB . 'AutoLoad.dll.php' );

        ErrorHandlerException::init( );
    }


    /**
    * Initialize Application
    * @return void
    */
    public function init( ) {
        try {
            $HttpRequest = new HttpRequest( );
            $pathInfo = $HttpRequest->request(GET, 'pathInfo' );

            $Dispatcher = new Dispatcher( );
            $Dispatcher->setMapping(XML . 'urlmap.xml' );
            $Dispatcher->monitor( $pathInfo );
        }
        catch( Exceptions $e ) {
            $e->record( );
        }
    }


    /**
     * Initialize Application
     * @return void
     */
    public function initCron( $argv ) {
        try {
            if( php_sapi_name() != 'cli' ) {
                throw new Exceptions("cron.php must be executed via terminal\n");
            }

            // send mime type and encoding
            @header('Content-Type: text/plain; charset=utf-8');

            // we do not want html markup in emulated CLI
            @ini_set('html_errors', 'off');

            BenchmarkTimer::start( );

            $Dispatcher = new Dispatcher( );
            $Dispatcher->setMapping(XML . 'cronmap.xml' );
            $Dispatcher->monitor('cron/', $argv);

            echo 'Main cron execution time took ' . BenchmarkTimer::stop('Aurora') . " seconds\n\n";
        }
        catch( Exceptions $e ) {
            $e->record( 'cronlog.php' );
            die( $e->toString( ) );
        }
    }
}
?>