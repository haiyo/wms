<?php
namespace Aurora;
use \Library\Database\DB, \Library\Http\HttpResponse;
use \Library\Util\XML, \Library\Util\Aurora\FilterManager, \Library\IO\File;
use \Aurora\Page\PageModel;
use \Markaxis\Company\CompanyModel;
use \Library\Exception\Aurora\AuthLoginException;
use \Library\Exception\Aurora\PageNotFoundException;
use \Library\Exception\Aurora\NoPermissionException;
use \Library\Exception\Aurora\SiteCheckException;
use \Library\Exception\FileNotFoundException;
use \Library\Exception\InstantiationException;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, July 4th, 2012
 * @version $Id: ControlPanelControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */
class ControlPanelControl extends Control {


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
    public function init( $args ) {
        try {
            // Initialize Database Access Point
            File::import( LIB . 'Database/DB.dll.php' );
            $DB = new DB( DBTYPE, DBHOST, DBNAME, DBUSER, DBPASS, DBPORT );
            $DB = $DB->connect( );

            // Load Application Settings from the Registry Table
            $this->initRegistry( );
            File::import( LIB . 'Runtime/Registry.dll.php' );
            File::import( DAO . 'DAO.class.php' );
            $this->Registry = \Library\Runtime\Registry::getInstance( );
            $this->Registry->setDB( $DB );
            $this->Registry->loadRegistry( );

            if( isset( $args[0] ) ) {
                $this->setXMLTasks( $args[0] );
            }
            $this->checkGateway( );

            // Setup company profile if not already
            File::import( MODEL . 'Markaxis/Company/CompanyModel.class.php' );
            $CompanyModel = CompanyModel::getInstance( );

            /*if( !$CompanyModel->loadInfo( ) ) {
                if( isset( $args[0] ) && $args[0] != 'company' ) {
                    // Redirect to setup page!
                    //header( 'location: ' . ROOT_URL . 'admin/company/setup' );
                    //exit;
                }
            }
            // If no event request, just redirect to main page
            else */if( !isset( $args[0] ) && !self::$HttpRequest->request( POST, 'auroraLogin' ) ) {
                // Redirect to default page if user is authenticated and tries to load admin/
                header( 'location: ' . ROOT_URL . 'admin/dashboard' );
                exit;
            }
            else if( self::$HttpRequest->request( POST, 'auroraLogin' ) ) {
                File::import( MODEL . 'Aurora/Page/PageModel.class.php' );
                $PageModel = PageModel::getInstance( );
                $defPageInfo = $PageModel->getDefaultPage( );
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
        catch( FileNotFoundException $e ) {
            $e->record( );
            HttpResponse::sendHeader( HttpResponse::HTTP_INTERNAL_SERVER_ERROR );
        }
    }


    /**
     * Check if requested task needs authentication access and assign the correct task list (xml)
     * @return bool
     */
    public function setXMLTasks( $task ) {
        File::import( LIB . 'Util/XML.dll.php' );
        $XML = new XML( );
        $XMLElement = $XML->load( XML . 'Aurora/admin-no.xml' );
        $sizeof = sizeof( $XMLElement->task );

        for( $i=0; $i<$sizeof; $i++ ) {
            if( $XMLElement->task[$i]['type'] == $task ) {
                $this->xmlTaskFile = XML . 'Aurora/admin-no.xml';
                $this->xmlGatewayFile = XML . 'Aurora/gateway-no.xml';
            }
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

            $vars = array( );

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