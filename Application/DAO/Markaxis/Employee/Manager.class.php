<?php
namespace Markaxis\Employee;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Manager.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Manager extends \DAO {


    // Properties


    /**
     * Manager Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID, $managerID ) {
        $sql = $this->DB->select( 'SELECT COUNT(svID) FROM employee_manager 
                                   WHERE userID = "' . (int)$userID . '" AND
                                         managerID = "' . (int)$managerID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all user roles
     * @return mixed
     */
    public function getByUserID( $userID ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT managerID FROM employee_manager 
                                   WHERE userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['managerID']] = $row['managerID'];
            }
        }
        return $list;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getNameByUserID( $userID ) {
        $sql = $this->DB->select( 'SELECT GROUP_CONCAT( CONCAT(fname," ",lname) SEPARATOR ";") AS name 
                                   FROM employee_manager es
                                   LEFT JOIN user u ON (u.userID = es.managerID)
                                   WHERE es.userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }
}
?>