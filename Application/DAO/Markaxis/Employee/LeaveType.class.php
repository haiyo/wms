<?php
namespace Markaxis\Employee;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: LeaveType.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveType extends \DAO {


    // Properties


    /**
     * LeaveType Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID ) {
        $sql = $this->DB->select( 'SELECT COUNT(eltID) FROM employee_leave_type
                                   WHERE userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user list normally use for building select list
     * @return mixed
     */
    public function getByUserID( $userID, $column ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT ' . addslashes( $column ) . ' FROM employee_leave_type
                                   WHERE userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }


    /**
     * Retrieve a user list normally use for building select list
     * @return mixed
     */
    public function getListByUserID( $userID ) {
        $sql = $this->DB->select( 'SELECT GROUP_CONCAT(DISTINCT ltID) AS ltID FROM employee_leave_type
                                   WHERE userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function existByLTIDs( $ltIDs ) {
        if( is_array( $ltIDs ) ) {
            $count = count( $ltIDs );

            $sql = $this->DB->select('SELECT CASE WHEN ( 
                                        SELECT COUNT(ltID) as cnt
                                        FROM leave_type
                                        WHERE ltID IN (' . addslashes( implode( ',', $ltIDs ) ) . ') ) = ' . (int)$count . '
                                        THEN 1
                                        ELSE 0 END',
                                      __FILE__, __LINE__);

            return $this->DB->resultData($sql);
        }
        return false;
    }
}
?>