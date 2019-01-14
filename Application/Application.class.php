<?php
use \Library\IO\File, Library\Http\URLDispatcher;
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
        
        File::import( LIB . 'Util/UserAgent.dll.php' );
        File::import( LIB . 'Http/HttpRequest.dll.php' );
        File::import( LIB . 'Http/HttpResponse.dll.php' );

        ErrorHandlerException::init( );
    }


    /**
    * Initialize Application
    * @return void
    */
    public function init( ) {
        try {
            File::import( LIB . 'Http/URLDispatcher.dll.php' );
            $URLDispatcher = new URLDispatcher( );
            $URLDispatcher->setMapping( XML . 'urlmap.xml' );
            $URLDispatcher->monitor('pathInfo');
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

            echo "\n-----------------------------------------------\n";
            echo "|         Cron Script Initializing...         |\n";
            echo "-----------------------------------------------\n\n";

            if( isset( $argv[1] ) && isset( $argv[2] ) ) {
                parse_str( $argv[1], $username );
                parse_str( $argv[2], $password );

                if( !isset( $username['u'] ) && !isset( $username['p'] ) ) {
                    die("Error: No username and password supplied\n\n");
                }

                $username = trim( $username['u'] );
                $password = trim( $password['p'] );

                if( !$username && !$password ) {
                    throw new Exceptions("Error: Please supply a valid username and password\n\n");
                }

                File::import( LIB . 'Util/BenchmarkTimer.dll.php' );
                BenchmarkTimer::start( );

                File::import( CONTROL . 'Admin/CronControl.class.php' );
                $CronControl = new CronControl( );
                $CronControl->init( );

                echo 'Main cron execution time took ' . BenchmarkTimer::stop('Aurora') . " seconds\n\n";
            }
            else {
                throw new Exceptions("Error: No username and password supplied\n\n");
            }
        }
        catch( Exceptions $e ) {
            $e->record( 'cronlog.php' );
            die( $e->toString( ) );
        }
    }
}
?>