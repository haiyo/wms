<?php
namespace Aurora\Admin;
use \Library\Database\DB, \Library\Http\HttpResponse;
use \Library\Util\XML, \Library\Util\Aurora\TaskManager, \Library\Util\Aurora\FilterManager;
use \Aurora\Page\PageModel;
use \Markaxis\Company\CompanyModel;
use \Library\Exception\Aurora\AuthLoginException;
use \Library\Exception\Aurora\PageNotFoundException;
use \Library\Exception\Aurora\TaskNotFoundException;
use \Library\Exception\Aurora\NoPermissionException;
use \Library\Exception\Aurora\SiteCheckException;
use \Library\Exception\InstantiationException;
use \Library\Exception\FileNotFoundException;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: ControlPanelControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AdminControl extends Control {


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
     * Connect database
     * @return void
     */
    public function connectDB( ) {
        // Initialize Database Access Point
        $DB = new DB( DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS, DBPORT );
        $DB = $DB->connect( );

        // Load Application Settings from the Registry Table
        $this->initRegistry( );
        $this->Registry = \Library\Runtime\Registry::getInstance( );
        $this->Registry->setDB( $DB );
        $this->Registry->loadRegistry( );
    }


    /**
     * Init Control Panel Controller Main
     * Override the parent Registry and extend Registry functionalities
     * @return void
     */
    public function init( $args ) {
        try {
            $this->connectDB();

            if( isset( $args[0] ) ) {
                $this->setXMLTasks( $args[0] );
            }

            // Setup company profile if not already
            $CompanyModel = CompanyModel::getInstance( );

            if( !$CompanyModel->loadInfo( ) ) {
                if( isset( $args[0] ) && $args[0] != 'company' ) {
                    // Redirect to setup page!
                    //header( 'location: ' . ROOT_URL . 'admin/company/setup' );
                    //exit;
                }
            }

            $this->checkGateway( );

            // Not in use currently because global actions will also run on every ajax call.
            // $this->global( array( 'global', 'globalInit' ) );

            // If no event request, just redirect to main page
            if( !isset( $args[0] ) && !self::$HttpRequest->request( POST, 'auroraLogin' ) ) {
                // Redirect to default page if user is authenticated and tries to load admin/
                header( 'location: ' . ROOT_URL . 'admin/dashboard' );
                exit;
            }
            else if( self::$HttpRequest->request( POST, 'auroraLogin' ) ) {
                $PageModel = PageModel::getInstance( );
                $defPageInfo = $PageModel->getDefaultPage( );

                if( !isset( $defPageInfo['pageID'] ) ) {
                    die('Page Error!');
                }
                echo $defPageInfo['pageID'];
                exit;
            }
            $this->{$args[0]}( $args );
        }
        catch( PageNotFoundException $e ) {
            $e->record( );
            HttpResponse::sendHeader( HttpResponse::HTTP_NOT_FOUND );
            header( 'location: ' . ROOT_URL . 'admin/notfound' );
        }
    }


    /**
     * Check if requested task needs authentication access and assign the correct task list (xml)
     * @return bool
     */
    public function setXMLTasks( $task ) {
        try {
            $XML = new XML( );
            $XMLElement = $XML->load( XML . 'Aurora/admin-no.xml' );
            $sizeof = sizeof( $XMLElement->task );

            // If not admin task, override the default xmlTaskFile
            for( $i=0; $i<$sizeof; $i++ ) {
                if( $XMLElement->task[$i]['type'] == $task ) {
                    $this->xmlTaskFile = XML . 'Aurora/admin-no.xml';
                    $this->xmlGatewayFile = XML . 'Aurora/gateway-no.xml';
                }
            }
        }
        catch( FileNotFoundException $e ) {
            $e->record( );
        }
    }


    /**
     * Admin Gateway Processing
     * @return void
     */
    public function checkGateway( ) {
        $vars = array( );

        try {
            $FilterManager = new FilterManager( );
            $FilterManager->processFilter( $this->xmlGatewayFile );
            $FilterManager->execute( self::$HttpRequest, self::$HttpResponse );
        }
        catch( AuthLoginException $e ) {
            $e->record( );

            if( self::$HttpResponse->getCode( ) == HttpResponse::HTTP_EXPECTATION_FAILED &&
                self::$HttpRequest->request( POST, 'auroraLogin' ) ) {
                $vars['error'] = 'loginError';
                die( json_encode( $vars ) );
            }
            if( self::$HttpResponse->getCode( ) == HttpResponse::HTTP_SERVICE_UNAVAILABLE &&
                self::$HttpRequest->request( POST, 'auroraLogin' ) ) {
                $vars['error'] = 'unavailable'; // Main login blocked
                die( json_encode( $vars ) );
            }
            if( self::$HttpResponse->getCode( ) == HttpResponse::HTTP_UNAUTHORIZED &&
                self::$HttpRequest->request( POST, 'ajaxCall' ) ) {
                $vars['error'] = 'login'; // Normal Ajax call re-login
                die( json_encode( $vars ) );
            }
            if( self::$HttpResponse->getCode( ) == HttpResponse::HTTP_EXPECTATION_FAILED ||
                self::$HttpResponse->getCode( ) == HttpResponse::HTTP_FORBIDDEN ||
                self::$HttpResponse->getCode( ) == HttpResponse::HTTP_UNAUTHORIZED ) {
                die( $this->login( ) );
            }
            echo 'AuthLoginException not tracked! Error code received: ' . self::$HttpResponse->getCode( );
            exit;
        }
        catch( NoPermissionException $e ) {
            $vars['error'] = 'loginError';
            die( json_encode( $vars ) );
        }
        catch( SiteCheckException $e ) {
            $e->record( );

            /**********REGISTRY TO BE CHANGE*******/

            // Site is turned off. Only allow Administrator to enter.
            $Authorization = $this->Registry->get( HKEY_CLASS, 'Authorization' );
            if( !$Authorization->isAdmin( ) ) {
                $vars['error'] = 'unavailable';
                die( json_encode( $vars ) );
            }
        }
    }


    /**
     * Magic Call
     * @return void
     */
    public function __call( $task, $args ) {
        try {
            $cacheArgs = array( );

            // Remove extra array from magic call.
            if( isset( $args[0][0] ) ) {
                array_shift( $args[0] );
                $args = $cacheArgs = $args[0];
            }
            $TaskManager = new TaskManager( );

            do {
                $secondaryTask = rtrim($task . '/' . implode('/', $args ),'/' );

                if( $TaskManager->foundTask( $this->xmlTaskFile, $secondaryTask ) ) {
                    $TaskManager->escalate( $cacheArgs );
                    break;
                }
                // If no secondary task found, we will fallback to main task.
                if( $TaskManager->foundTask( $this->xmlTaskFile, $task ) ) {
                    $TaskManager->escalate( $cacheArgs );
                    break;
                }
                array_pop($args );
            }
            while( sizeof( $args ) > 0 );
        }
        catch( InstantiationException $e ) {
            $e->record( );
        }
        catch( TaskNotFoundException $e ) {
            $e->record( );
            header( 'location: ' . ROOT_URL . 'admin/notFound' );
        }
    }
}
?>