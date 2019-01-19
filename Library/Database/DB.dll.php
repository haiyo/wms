<?php
namespace Library\Database;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: DB.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
*/

class DB {

    
    // Properties
    private $module;
    private $dbHost;
    private $dbName;
    private $dbUser;
    private $dbPass;


    /**
    * Assign properties
    * @return void
    */
    function __construct( $module, $dbHost, $dbName, $dbUser, $dbPass, $dbPort ) {
        $this->module = $module;
        $this->dbHost = $dbHost;
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
    	$this->dbPass = $dbPass;
    	$this->dbPort = $dbPort;
    }

    
    /**
    * Connect to database
    * @return obj DatastoreHelper
    */
    public function connect( ) {
        $class = '\\Library\Database\DBModules\\' . $this->module;
        return new $class( $this->dbHost, $this->dbName, $this->dbUser,
                                  $this->dbPass, $this->dbPort );
    }
}
?>