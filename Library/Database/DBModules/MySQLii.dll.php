<?php
namespace Library\Database\DBModules;
use Library\Helper\DataStoreHelper;
use Library\Exception\DatabaseException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: MySQLii.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class MySQLii extends DataStoreHelper {


    /**#@+
     * @access private
     * @var string
     */
    private $dbHost;
    private $dbName;
    private $dbUser;
    private $dbPass;
    private $dbPort;


    /**
     * Established connection handler
     * @access private
     * @var int Resource ID
     */
    private $conn;


    /**
     * MySQL Constructor - Performs Connection
     * @return void
     */
    public function __construct( $dbHost, $dbName, $dbUser, $dbPass, $dbPort=3306 ) {
        $this->dbHost = (string)$dbHost;
        $this->dbName = (string)$dbName;
        $this->dbUser = (string)$dbUser;
        $this->dbPass = (string)$dbPass;
        $this->dbPort = (int)$dbPort;
        $this->connect( );
    }


    /**
     * Open connection to the MySQL DBMS
     * @throws DatabaseException
     * @access private
     * @return void
     */
    private function connect( ) {
        try {
            $dbHost = $this->dbHost ;
            $this->conn = mysqli_connect( $dbHost, $this->dbUser, $this->dbPass );
            $this->dbHost = NULL; $this->dbPass = NULL;
            $this->dbUser = NULL; $this->dbPort = NULL;

            if( !$this->conn ) {
                throw( new DatabaseException('Unable to connect MySQLi') );
            }
            if (!$this->conn->set_charset('utf8')) {
                throw( new DatabaseException('Error loading character set utf8: ' . $this->conn->error ) );
            }
            $this->selectDB( );
        }
        catch( DatabaseException $e ) {
            $e->record();
        }
    }


    /**
     * Select database
     * @throws DatabaseException
     * @access private
     * @return void
     */
    private function selectDB( ) {
        if( !mysqli_select_db( $this->conn, $this->dbName ) ) {
            $this->dbName = NULL;
            throw( new DatabaseException( mysqli_error($this->conn) ) );
        }
    }


    /**
     * Selects rows from the database with the given SQL query
     * @param $query string
     * @param $file string Script location where query execute
     * @param $line int Line location on query invoke
     * @return int Resource ID
     */
    public function select( $query, $file, $line ) {
        try {
            if( !$sql = mysqli_query( $this->conn, $query ) ) {
                throw( new DatabaseException( mysqli_error( $this->conn ) . ' on query: ' .
                    $query, mysqli_errno( $this->conn ), $file, $line ) );
            }
            return $sql;
        }
        catch( DatabaseException $e ) {
            $e->record();
        }
    }


    /**
     * Return last insert ID
     * @return int Last insert ID
     */
    public function lastID() {
        return mysqli_insert_id( $this->conn );
    }


    /**
     * Insert rows and return the last insert ID generated by the database.
     * @param $query string
     * @param $file string Script location where query execute
     * @param $line int Line location on query invoke
     * @return int Last insert ID
     */
    public function insert( $query, $file, $line ) {
        $this->select( $query, $file, $line );
        return @mysqli_insert_id( $this->conn );
    }


    /**
     * Updates row and return the number of rows updated.
     * @param $query string
     * @param $file string Script location where query execute
     * @param $line int Line location on query invoke
     * @return int Number of affected rows
     */
    public function update( $query, $file, $line ) {
        $this->select( $query, $file, $line );
        return @mysqli_affected_rows( $this->conn );
    }


    /**
     * Fetch and return an array of results from the database, or FALSE if null.
     * @param $queryID int.
     * @returns mixed[] / false
     */
    public function fetch( $queryID, $assoc=true ) {
        if( $assoc )
            return $queryID ? mysqli_fetch_array( $queryID, MYSQLI_ASSOC ) : false;
        else
            return $queryID ? mysqli_fetch_array( $queryID ) : false;
    }


    /**
     * Delete row and return the number of rows deleted.
     * @param $query string
     * @param $file string Script location where query execute
     * @param $line int Line location on query invoke
     * @return int Number of affected rows
     */
    public function delete( $query, $file, $line ) {
        $this->select( $query, $file, $line );
        return mysqli_affected_rows( $this->conn );
    }


    /**
     * Return number of rows retrieved, or 0 if null.
     * @param $queryID int
     * @return int
     */
    public function numrows( $queryID ) {
        return $queryID ? mysqli_num_rows( $queryID ) : 0;
    }


    /**
     * Return number of fields or FALSE if null.
     * @param $queryID int
     * @return int
     */
    public function numfields( $queryID ) {
        return $queryID ? @mysqli_num_fields( $queryID ) : 0;
    }


    /**
     * Returns the contents of one cell from result set, or 0 if null.
     * @param $queryID int
     * @return int
     */
    public function resultData( $queryID ) {
        $row = $queryID ? mysqli_fetch_array( $queryID ) : false;
        return $row[0];
        //return $queryID ? mysqli_result( $queryID, 0 ) : 0;
    }


    /**
     * Get database size
     * @return int
     */
    public function size( ) {
        $sql = $this->select( 'SHOW TABLE STATUS FROM ' . addslashes( $this->dbName ), __FILE__, __LINE__ );
        $total = 0;
        while( $row = $this->fetch( $sql ) ) {
            $total += round( $row['Index_length'] + $row['Data_length'] / 1024, 2 );
        }
        return $total;
    }


    /**
     * Get MySQLi Version
     * @return string
     */
    public function version( ) {
        $sql = $this->select( 'SELECT VERSION()', __FILE__, __LINE__ );
        $row = $this->fetch( $sql );
        return 'MySQL/' . $row['VERSION()'];
    }


    /**
     * Close Database Connection
     * @return void
     */
    public function __destruct( ) {
        if( $this->conn ) {
            mysqli_close( $this->conn );
        }
    }
}