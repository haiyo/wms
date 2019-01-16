<?php
namespace Aurora;
use \Library\Security\Aurora\Authenticator;
use \Library\Database\DB;
use \Library\Util\Aurora\FilterManager, \Library\IO\File;
use \Library\Exception\Aurora\AuthLoginException;
use \Library\Exception\Aurora\NoPermissionException;
use \Library\Exception\Aurora\SiteCheckException;
use \Library\Exception\FileNotFoundException;
use \Library\Exception\InstantiationException;
use \Control, \i18n;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, July 4th, 2012
 * @version $Id: CronControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
class CronControl extends Control {


    // Properties
    protected $xmlTaskFile;
    protected $xmlGatewayFile;


    /**
    * ControlPanelControl Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->xmlTaskFile = XML . 'Aurora/admin.xml';
        $this->xmlGatewayFile = XML . 'Aurora/gateway.xml';
	}


    /**
    * Init Control Panel Controller Main
    * Override the parent Registry and extend Registry functionalities
    * @return void
    */
    public function init( $argv ) {
        try {
            if( isset( $argv[1] ) && isset( $argv[2] ) ) {
                parse_str($argv[1], $username);
                parse_str($argv[2], $password);

                if (!isset($username['u']) && !isset($username['p'])) {
                    die("Error: No username and password supplied\n\n");
                }

                $username = trim($username['u']);
                $password = trim($password['p']);

                if (!$username && !$password) {
                    throw new Exceptions("Error: Please supply a valid username and password\n\n");
                }
                // Initialize Database Access Point
                File::import(LIB . 'Database/DB.dll.php');
                $DB = new DB(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS, DBPORT);
                $DB = $DB->connect();

                // Load Application Settings from the Registry Table
                $this->initRegistry();
                File::import(LIB . 'Runtime/Registry.dll.php');
                File::import(DAO . 'DAO.class.php');
                $this->Registry = \Library\Runtime\Registry::getInstance();
                $this->Registry->setDB( $DB );
                $this->Registry->loadRegistry( );

                File::import( LANG . 'i18n.dll.php' );
                $i18n = new i18n('Aurora/languages.xml');
                $i18n->setUserLang( $this->Registry->get( HKEY_LOCAL, 'language' ) );
                $this->Registry->set( HKEY_CLASS, 'i18n', $i18n );

                File::import(LIB . 'Security/Aurora/Authenticator.dll.php');
                $Authenticator = new Authenticator();

                if( !$Authenticator->login( $username, $password, false ) ) {
                    throw new Exceptions("Error: Invalid username and password.\n\n");
                }

                $Scheduler = new Scheduler( );
                $Scheduler->run( );

                // Load tasks
            }
            else {
                throw new Exceptions("Error: No username and password supplied.\n\n");
            }
        }
        catch( Exception $e ) {
            $e->record( );
            $e->toString( );
        }
    }


    /**
    * Admin Gateway Processing
    * @return void
    */
    public function checkGateway( ) {
        try {
            File::import( LIB . 'Util/Aurora/FilterManager.dll.php' );
            $FilterManager = new FilterManager( );
            $FilterManager->processFilter( $this->xmlGatewayFile );
            $FilterManager->execute( self::$HttpRequest, self::$HttpResponse );
        }
        catch( AuthLoginException $e ) {
            $e->record( );
            $e->toString( );
            exit;
        }
        catch( NoPermissionException $e ) {
            $e->record( );
            echo 0;
            exit;
        }
        catch( SiteCheckException $e ) {
            $e->record( );

            /**********REGISTRY TO BE CHANGE*******/

            // Site is turned off. Only allow Administrator to enter.
            $Authorization = $this->Registry->get( HKEY_CLASS, 'Authorization' );
            if( !$Authorization->isAdmin( ) ) {
                die( );
            }
        }
    }


    /**
    * Magic Call
    * @return void
    */
    public function __call( $task, $args ) {
        try {
            // Remove extra array from magic call.
            if( isset( $args[0][0] ) ) {
                array_shift( $args[0] );
                $args = $args[0];
            }
            File::import( LIB . 'Util/TaskManager.dll.php' );
            File::import( LIB . 'Util/Aurora/TaskManager.dll.php' );
            $TaskManager = new TaskManager( );
            $TaskManager->addTask( $this->xmlTaskFile, $task );
            $TaskManager->escalate( $args );
        }
        catch( InstantiationException $e ) {
            $e->record( );
        }
        catch( FileNotFoundException $e ) {
            $e->record( );
        }
        catch( PageNotFoundException $e ) {
            $e->record( );
            header( 'location: ' . ROOT_URL . 'admin/notFound' );
        }
    }
}
?>