<?php
namespace Aurora\Admin;
use \Library\Database\DB;
use \Library\Security\Aurora\Authenticator;
use \Library\Exception\Exceptions;
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
    public function init( $argv ) {
        try {
            if( isset( $argv[1] ) && isset( $argv[2] ) ) {
                parse_str( $argv[1], $username );
                parse_str( $argv[2], $password );

                if( !isset( $username['u'] ) || !isset( $password['p'] ) ) {
                    die("Error: No username and password supplied\n\n");
                }

                $username = trim( $username['u'] );
                $password = trim( $password['p'] );

                if( !$username && !$password ) {
                    throw new Exceptions("Error: Please supply a valid username and password\n\n");
                }

                $this->connectDB();

                $i18n = new i18n('Aurora/languages.xml');
                $i18n->setUserLang( $this->Registry->get( HKEY_LOCAL, 'language' ) );
                $this->Registry->set( HKEY_CLASS, 'i18n', $i18n );

                $Authenticator = new Authenticator( );

                if( !$Authenticator->login( $username, $password, false ) ) {
                    throw new Exceptions("Error: Invalid username and password.\n\n");
                }

                $this->runTasks( );
                exit;
            }
            else {
                throw new Exceptions("Error: No username and password supplied.\n\n");
            }
        }
        catch( Exceptions $e ) {
            $e->record( );
            die( $e->toString( ) );
        }
    }


    /**
    * Magic Call
    * @return void
    */
    public function runTasks( ) {
        $CronModel = new CronModel( );
        $CronModel->run( );
    }
}
?>