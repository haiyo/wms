<?php
namespace Markaxis\Employee;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Employee.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Employee extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $eID ) {
        $sql = $this->DB->select( 'SELECT COUNT(eID) FROM employee e
                                   LEFT JOIN user u ON ( u.userID = e.userID )
                                   WHERE eID = "' . (int)$eID . '" AND 
                                         u.deleted <> "1" AND e.resigned <> "1"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID ) {
        $sql = $this->DB->select( 'SELECT COUNT(eID) FROM employee e
                                   LEFT JOIN user u ON ( u.userID = e.userID )
                                   WHERE u.userID = "' . (int)$userID . '" AND
                                         u.deleted <> "1" AND e.resigned <> "1"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user list normally use for building select list
     * @return mixed
     */
    public function getList( $q='', $excludeUserID='' ) {
        $q = $q ? addslashes( $q ) : '';
        $q = $q ? 'AND ( CONCAT( u.fname, \' \', u.lname ) LIKE "' . $q . '%" )' : '';

        $exclude = $excludeUserID ? 'AND u.userID NOT IN(' . addslashes( $excludeUserID ) . ')' : '';

        $list = array( );

        $sql = $this->DB->select( 'SELECT u.userID, CONCAT( u.fname, " ", u.lname ) AS name,
                                          d.title AS designation
                                   FROM user u
                                   LEFT JOIN employee e ON ( e.userID = u.userID )
                                   LEFT JOIN designation d ON ( e.designationID = d.dID )
                                   WHERE e.resigned <> "1" AND u.suspended <> "1" AND u.deleted <> "1" ' . $q . ' ' . $exclude . '
                                   ORDER BY name ASC', __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getFieldByUserID( $userID, $column ) {
        $sql = $this->DB->select( 'SELECT ' . addslashes( $column ) . ' FROM user u
                                   LEFT JOIN employee e ON ( e.userID = u.userID )
                                   WHERE u.userID = "' . (int)$userID . '" AND u.deleted <> "1" AND e.resigned <> "1"',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getResults( $q='', $order='name ASC' ) {
        $list = array( );

        if( $q == 'active' ) {
            $q = 'AND u.suspended = "0"';
        }
        else {
            $q = $q ? addslashes( $q ) : '';
            $q = $q ? 'AND ( CONCAT( u.fname, \' \', u.lname ) LIKE "%' . $q . '%" OR d.title LIKE "%' . $q . '%" 
                       OR e.idnumber = "' . $q . '" OR u.email1 LIKE "%' . $q . '%" OR e.startdate LIKE "%' . $q . '%"
                       OR c.type LIKE "%' . $q . '%" OR d.title LIKE "%' . $q . '%")' : '';
        }

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS u.userID, CONCAT( u.fname, \' \', u.lname ) AS name,
                                          u.email1, u.mobile,
                                          u.suspended, e.startdate, d.title AS designation, e.currency,
                                          e.idnumber, e.salary, e.endDate, c.type,
                                          ad.descript AS suspendReason
                                   FROM user u
                                   LEFT JOIN employee e ON ( e.userID = u.userID )
                                   LEFT JOIN designation d ON ( d.dID = e.designationID )
                                   LEFT JOIN contract c ON ( c.cID = e.contractID )
                                   LEFT JOIN ( SELECT toUserID, descript FROM audit_log 
                                               WHERE eventType = "employee" AND ( action = "suspend" OR action = "unsuspend" )
                                               ORDER BY created DESC LIMIT 1 ) ad ON ad.toUserID = u.userID
                                   WHERE u.deleted <> "1" AND e.resigned <> "1" ' . $q . '
                                   ORDER BY ' . $order . $this->limit,
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        $sql = $this->DB->select( 'SELECT FOUND_ROWS()', __FILE__, __LINE__ );
        $row = $this->DB->fetch( $sql );
        $list['recordsTotal'] = $row['FOUND_ROWS()'];
        return $list;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getLogsByUserID( $q, $userID, $order='al.created DESC' ) {
        $list = array( );

        $q = $q ? addslashes( $q ) : '';
        $q = $q ? 'AND ( al.eventType LIKE "%' . $q . '%" OR al.action LIKE "%' . $q . '%" 
                   OR al.descript LIKE "%' . $q . '%" )' : '';

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS al.*
                                   FROM audit_log al
                                   LEFT JOIN user u ON ( u.userID = al.fromUserID )
                                   LEFT JOIN user u2 ON ( u2.userID = al.toUserID )
                                   WHERE al.toUserID = "' . (int)$userID . '" ' . $q . '
                                   ORDER BY ' . $order . $this->limit,
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        $sql = $this->DB->select( 'SELECT FOUND_ROWS()', __FILE__, __LINE__ );
        $row = $this->DB->fetch( $sql );
        $list['recordsTotal'] = $row['FOUND_ROWS()'];
        return $list;
    }
}
?>