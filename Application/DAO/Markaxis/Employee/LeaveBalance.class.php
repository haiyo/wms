<?php
namespace Markaxis\Employee;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: LeaveBalance.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveBalance extends \DAO {


    // Properties


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getByltIDUserID( $ltID, $userID ) {
        $sql = $this->DB->select( 'SELECT lb.balance FROM employee_leave_bal lb
                                   WHERE lb.ltID = "' . (int)$ltID . '" AND
                                         lb.userID = "' . (int)$userID . '"',
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
    public function getByUserID( $userID ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT lt.name, lb.balance FROM employee_leave_bal lb
                                   JOIN leave_type lt ON ( lt.ltID = lb.ltID )
                                   WHERE lb.userID = "' . (int)$userID . '"' . $this->limit,
                                   __FILE__, __LINE__ );

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
    public function getTypeListByUserID( $userID ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT lt.ltID, lt.name FROM employee_leave_bal elb
                                   LEFT JOIN leave_type lt ON ( lt.ltID = elb.ltID )
                                   WHERE elb.userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['ltID']] = $row['name'];
            }
        }
        return $list;
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getSidebarByUserID( $userID ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT lt.ltID, lt.name, elb.balance FROM employee_leave_bal elb
                                   LEFT JOIN leave_type lt ON ( lt.ltID = elb.ltID )
                                   WHERE elb.userID = "' . (int)$userID . '" AND elb.sidebar = "1"',
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
    public function getList( $userID, $order='name ASC' ) {
        $q = $q ? addslashes( $q ) : '';
        $q = $q ? 'AND ( CONCAT( u.fname, \' \', u.lname ) LIKE "%' . $q . '%" OR u.email1 LIKE "%' . $q . '%" )' : '';

        $list = array( );

        $sql = $this->DB->select( 'SELECT u.userID, CONCAT(u.fname, " ", u.lname ) AS name FROM user u
                                   LEFT JOIN employee e ON ( e.userID = u.userID )
                                   WHERE e.resigned <> "1" AND u.suspended <> "1" AND deleted <> "1" ' . $q . '
                                   ORDER BY name ASC', __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
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
                       OR c.type LIKE "%' . $q . '%" )' : '';
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
}
?>