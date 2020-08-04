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
     * Return total count of records
     * @return int
     */
    public function getCount( ) {
        $sql = $this->DB->select( 'SELECT COUNT(eID) FROM employee e',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getCountByDate( $endDate ) {
        $sql = $this->DB->select( 'SELECT COUNT(eID) FROM employee e 
                                   WHERE endDate IS NOT NULL AND endDate <= "' . addslashes( $endDate ) . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user list normally use for building select list
     * @return mixed
     */
    public function getList( $q='', $departmentID, $designationID, $excludeUserID='' ) {
        $q = $q ? addslashes( $q ) : '';
        $q = $q ? 'AND ( CONCAT( u.fname, \' \', u.lname ) LIKE "' . $q . '%" OR u.email1 LIKE "%' . $q . '%" )' : '';

        $exclude = $excludeUserID ? ' AND u.userID NOT IN(' . addslashes( $excludeUserID ) . ')' : '';
        $department = $departmentID ? ' AND FIND_IN_SET("' . (int)$departmentID . '", ed.departmentID)' : '';
        $designation = $designationID ? ' AND d.dID = "' . (int)$designationID . '"' : '';

        $list = array( );

        $sql = $this->DB->select( 'SELECT DISTINCT u.userID, CONCAT( u.fname, " ", u.lname ) AS name, u.email1 AS email,
                                          u.mobile, d.title AS designation,
                                          IFNULL(ed.department, "" ) AS department
                                   FROM user u
                                   LEFT JOIN employee e ON ( e.userID = u.userID )
                                   LEFT JOIN designation d ON ( e.designationID = d.dID )
                                   LEFT JOIN ( SELECT userID, GROUP_CONCAT(DISTINCT dpt.dID) AS departmentID,
                                               GROUP_CONCAT(DISTINCT dpt.name ORDER BY dpt.name) AS department
                                               FROM employee_department ed
                                               LEFT JOIN department dpt ON ( dpt.dID = ed.departmentID )
                                               WHERE dpt.deleted <> "1"
                                               GROUP BY ed.userID ) ed ON ed.userID = u.userID
                                   WHERE e.resigned <> "1" AND u.suspended <> "1" AND u.deleted <> "1" ' . $q .
                                         $exclude . $department . $designation . '
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
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getProcessInfo( $userID ) {
        $sql = $this->DB->select( 'SELECT u.userID, CONCAT( u.fname, " ", u.lname ) AS name,
                                          u.birthday, u.raceID, n.nationality, e.idnumber, 
                                          dpt.name AS department, d.title AS designation, c.type AS contractType, 
                                          e.officeID, e.salary, pt.title AS passType,
                                          CONCAT( cty.currencyCode, "", cty.currencySymbol ) AS currency,
                                          DATE_FORMAT(e.startDate, "%D %b %Y") AS startDate, 
                                          DATE_FORMAT(e.confirmDate, "%D %b %Y") AS confirmDate, 
                                          DATE_FORMAT(e.endDate, "%D %b %Y") AS endDate
                                   FROM employee e
                                   LEFT JOIN user u ON ( u.userID = e.userID )
                                   LEFT JOIN country cty ON ( cty.cID = u.countryID )
                                   LEFT JOIN nationality n ON ( n.nID = u.nationalityID )
                                   LEFT JOIN department dpt ON ( dpt.dID = e.departmentID )
                                   LEFT JOIN designation d ON ( d.dID = e.designationID )
                                   LEFT JOIN contract c ON ( c.cID = e.contractID )
                                   LEFT JOIN pass_type pt ON ( pt.ptID = e.passTypeID )
                                   WHERE e.resigned <> "1" AND e.userID = "' . (int)$userID . '"',
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