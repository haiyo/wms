<?php
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: DAO.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DAO {


    // Properties
    protected $DB;
    protected $limit;


    /**
    * DAO Constructor
    * @return void
    */
    function __construct( ) {
        $Registry = Registry::getInstance( );
        $this->DB = $Registry->get( HKEY_CLASS, 'DB' );
        $this->limit = '';
	}


    /**
    * Sekect record
    * @return mixed
    */
    public function setLimit( $start, $limit ) {
        if( $start > 0 && $limit > 0 ) {
            //$start = $limit*$currPage-$limit;
            $this->limit = ' LIMIT ' . (int)$start . ', ' . (int)$limit;
            return;
        }
        if( $limit > 0 ) {
            $this->limit = ' LIMIT ' . (int)$limit;
            return;
        }
    }


    /**
    * Sekect record
    * @return mixed
    */
    public function select( $query ) {
        return $this->DB->select( $query . $this->limit, __FILE__, __LINE__ );
    }


    /**
     * Insert record to table
     * @return int
     */
    public function fetch( $sql ) {
        return $this->DB->fetch( $sql );
    }


    /**
    * Insert record to table
    * @return int
    */
    public function insert( $table, $info ) {
        return $this->DB->insert( 'INSERT INTO ' . addslashes( $table ) . '
                                   SET ' . $this->DB->compose( $info ),
                                   __FILE__, __LINE__ );
    }


    /**
    * Update record
    * @return int
    */
    public function update( $table, $info, $where ) {
        return $this->DB->update( 'UPDATE ' . addslashes( $table ) . '
                                   SET ' . $this->DB->compose( $info ) . ' ' .
                                   $where,
                                   __FILE__, __LINE__ );
    }


    /**
    * More advanced update statement if needed
    * @return int
    */
    public function updateCustom( $table, $statement, $where ) {
        return $this->DB->update( 'UPDATE ' . addslashes( $table ) . ' SET ' .
                                   addslashes( $statement ) . ' ' .
                                   $where,
                                   __FILE__, __LINE__ );
    }


    /**
    * Delete record
    * @return int
    */
    public function delete( $table, $where ) {
        return $this->DB->delete( 'DELETE FROM ' . addslashes( $table ) . ' ' . $where,
                                   __FILE__, __LINE__ );
    }


    /**
    * Check if table exist
    * @return bool
    */
    public function tableExist( $table ) {
        $this->DB->select( 'DESC ' . addslashes( $table ), __FILE__, __LINE__ );
        if( mysql_errno( ) == 1146 ) {
            return false;
        }
        return true;
    }


    /**
    * Export table and record
    * @return mixed
    */
    public function export( $table, $data=true ) {
        $sql = $this->DB->select( 'SHOW CREATE TABLE ' . addslashes( $table ), __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            $row = $this->DB->fetch( $sql );
            
            $dump  = '# Table structure for table "' . addslashes( $table ) . '"' . "\n\n";
            $dump .= 'DROP TABLE IF EXISTS ' . addslashes( $table ) . ';' . "\n";
            $dump .= $row['Create Table'] . ";\n\n";

            if( $data ) {
                $dump .= '# Dumping data for table "' . addslashes( $table ) . '"' . "\n\n";

                $sql = $this->DB->select( 'SELECT * FROM ' . addslashes( $table ), __FILE__, __LINE__ );
                $num = $this->DB->numfields( $sql );
                
                while( $row = $this->DB->fetch( $sql, false ) ) {
                    $dump .= 'INSERT INTO ' . addslashes( $table ) . ' VALUES(';
                    for( $i=0; $i<$num; $i++ ) {
                    	$dump .= '"' . mysql_escape_string( $row[$i] ) . '"';
                        if( ($i+1) != $num ) {
                        	$dump .= ', ';
                        }
                    }
                    $dump .= ");\n";
                }
            }
            return $dump;
        }
        return false;
    }
}
?>