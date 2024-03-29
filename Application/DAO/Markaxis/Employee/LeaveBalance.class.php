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
     * Return total count of records
     * @return int
     */
    public function isFoundByltID( $ltID ) {
        $sql = $this->DB->select( 'SELECT COUNT(elbID) FROM employee_leave_bal
                                   WHERE ltID = "' . (int)$ltID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getByltIDUserID( $ltID, $userID, $year=false ) {
        if( !$year ) {
            $year = 'YEAR( CURDATE( ) )';
        }

        $sql = $this->DB->select( 'SELECT lb.*, la.totalPending, la2.totalConsumed, COUNT(lg.lgID) AS groupCount 
                                   FROM employee_leave_bal lb
                                   LEFT JOIN leave_group lg ON lg.ltID = lb.ltID
                                   LEFT JOIN (SELECT ltID, SUM(days) AS totalPending FROM leave_apply 
                                              WHERE ltID = "' . (int)$ltID . '" AND 
                                                    userID = "' . (int)$userID . '" AND
                                                    status = "0") la ON la.ltID = lb.ltID
                                   LEFT JOIN (SELECT ltID, SUM(days) AS totalConsumed FROM leave_apply 
                                              WHERE ltID = "' . (int)$ltID . '" AND 
                                                    userID = "' . (int)$userID . '" AND
                                                    status = "1") la2 ON la2.ltID = lb.ltID
                                   WHERE lb.ltID = "' . (int)$ltID . '" AND
                                         lb.userID = "' . (int)$userID . '" AND 
                                         lb.year = ' . addslashes( $year ) . '
                                         GROUP BY lb.elbID, la.totalPending, la2.totalConsumed',
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
        $sql = $this->DB->select( 'SELECT lt.name, lb.balance FROM employee_leave_bal lb
                                   JOIN leave_type lt ON ( lt.ltID = lb.ltID )
                                   WHERE lb.userID = "' . (int)$userID . '"' . $this->limit,
                                   __FILE__, __LINE__ );

        $list = array( );
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
        $sql = $this->DB->select( 'SELECT lt.ltID, lt.name FROM employee_leave_bal elb
                                   LEFT JOIN leave_type lt ON ( lt.ltID = elb.ltID )
                                   WHERE elb.userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        $list = array( );
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
        $sql = $this->DB->select( 'SELECT lt.ltID, lt.name, elb.balance FROM employee_leave_bal elb
                                   LEFT JOIN leave_type lt ON ( lt.ltID = elb.ltID )
                                   WHERE elb.userID = "' . (int)$userID . '" AND
                                         elb.year = YEAR( CURDATE( ) )
                                   ORDER BY elbID ASC' .
                                   $this->limit,
                                   __FILE__, __LINE__ );

        $list = array( );
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
        $q = $q ? 'AND ( CONCAT( u.fname, \' \', u.lname ) LIKE "%' . $q . '%" OR u.email LIKE "%' . $q . '%" )' : '';

        $list = array( );

        $sql = $this->DB->select( 'SELECT u.userID, CONCAT(u.fname, " ", u.lname ) AS name FROM user u
                                   LEFT JOIN employee e ON ( e.userID = u.userID )
                                   WHERE e.resigned <> "1" AND u.suspended <> "1" AND deleted <> "1" ' . $q . '
                                   ORDER BY name ASC',
                                   __FILE__, __LINE__ );

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
        if( $q == 'active' ) {
            $q = 'AND u.suspended = "0"';
        }
        else {
            $q = $q ? addslashes( $q ) : '';
            $q = $q ? 'AND ( CONCAT( u.fname, \' \', u.lname ) LIKE "%' . $q . '%" OR d.title LIKE "%' . $q . '%" 
                       OR e.idnumber = "' . $q . '" OR u.email LIKE "%' . $q . '%" OR e.startdate LIKE "%' . $q . '%"
                       OR c.type LIKE "%' . $q . '%" )' : '';
        }

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS u.userID, CONCAT( u.fname, \' \', u.lname ) AS name,
                                          u.email, u.mobile,
                                          u.suspended, e.startdate, d.title AS designation,
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

        $list = array( );
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