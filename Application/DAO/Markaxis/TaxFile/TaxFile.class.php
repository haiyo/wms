<?php
namespace Markaxis\TaxFile;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxFile.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxFile extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $piID ) {
        $sql = $this->DB->select( 'SELECT COUNT(piID) FROM payroll_item 
                                   WHERE piID = "' . (int)$piID . '" AND deleted <> "1"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByTFID( $tfID ) {
        $sql = $this->DB->select( 'SELECT * FROM taxfile 
                                   WHERE tfID = "' . (int)$tfID . '"',
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
    public function getByFileYear( $year, $batch ) {
        $sql = $this->DB->select( 'SELECT * FROM taxfile 
                                   WHERE fileYear = "' . (int)$year . '" AND 
                                         batch = "' . addslashes( $batch ) . '"',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getList( ) {
        $sql = $this->DB->select( 'SELECT piID AS id, title FROM payroll_item
                                   WHERE deleted <> "1"
                                   ORDER BY title', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['id']] = $row['title'];
            }
        }
        return $list;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getResults( $q, $order='fileYear DESC' ) {
        $list = array( );

        $q = '';
        //$q = $q ? addslashes( $q ) : '';
        //$q = $q ? 'AND pi.title LIKE "%' . $q . '%"' : '';

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS * FROM taxfile tf
                                   WHERE 1 = 1 ' . $q . '
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
    public function getEmployeeResults( $officeID, $tfID, $q='', $order='name ASC' ) {
        $list = array( );

        if( $q == 'active' ) {
            $q = 'AND u.suspended = "0"';
        }
        else {
            $q = $q ? addslashes( $q ) : '';
            $q = $q ? 'AND ( CONCAT( u.fname, \' \', u.lname ) LIKE "%' . $q . '%" OR d.title LIKE "%' . $q . '%" 
                       OR e.idnumber = "' . $q . '" OR u.email LIKE "%' . $q . '%" OR e.startdate LIKE "%' . $q . '%"
                       OR c.type LIKE "%' . $q . '%" OR d.title LIKE "%' . $q . '%")' : '';
        }

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS u.userID, CONCAT( u.fname, \' \', u.lname ) AS name,
                                          u.email, u.mobile,
                                          u.suspended, e.resigned, e.startdate, d.title AS designation,
                                          e.idnumber, e.salary, e.endDate, c.type,
                                          ad.descript AS suspendReason,
                                          ( SELECT COUNT(*) FROM ir8a ira
                                              WHERE ira.userID = u.userID AND
                                                    ira.tfID = "' . (int)$tfID . '" ) AS irCount
                                   FROM user u
                                   LEFT JOIN employee e ON ( e.userID = u.userID )
                                   LEFT JOIN designation d ON ( d.dID = e.designationID )
                                   LEFT JOIN contract c ON ( c.cID = e.contractID )
                                   LEFT JOIN ( SELECT toUserID, descript FROM audit_log 
                                               WHERE eventType = "employee" AND ( action = "suspend" OR action = "unsuspend" )
                                               ORDER BY created DESC LIMIT 1 ) ad ON ad.toUserID = u.userID
                                   WHERE u.deleted <> "1" AND e.officeID = "' . (int)$officeID . '" ' . $q . '
                                   GROUP BY u.userID, e.resigned, e.startDate, d.title, e.idnumber, e.salary, e.endDate, c.type, ad.descript
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
    public function getDeclarationResults( $officeID, $tfID, $q='', $order='name ASC' ) {
        $list = array( );

        if( $q == 'active' ) {
            $q = 'AND u.suspended = "0"';
        }
        else {
            $q = $q ? addslashes( $q ) : '';
            $q = $q ? 'AND ( CONCAT( u.fname, \' \', u.lname ) LIKE "%' . $q . '%"
                       OR u.email LIKE "%' . $q . '%" OR e.startdate LIKE "%' . $q . '%"' : '';
        }

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS u.userID, CONCAT( u.fname, \' \', u.lname ) AS name
                                   FROM user u
                                   LEFT JOIN employee e ON ( e.userID = u.userID )
                                   LEFT JOIN ir8a ira ON ( ira.userID = u.userID )
                                   WHERE u.deleted <> "1" AND 
                                         e.officeID = "' . (int)$officeID . '" AND 
                                         ira.tfID = "' . (int)$tfID . '" ' . $q . '
                                   GROUP BY u.userID
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
     * Return total count of records
     * @return int
     */
    public function isCompleted( $tfID ) {
        $sql = $this->DB->select( 'SELECT COUNT(*) FROM taxfile 
                                   WHERE tfID = "' . (int)$tfID . '" AND 
                                         completed = "1"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isSubmitted( $tfID ) {
        $sql = $this->DB->select( 'SELECT COUNT(*) FROM taxfile 
                                   WHERE tfID = "' . (int)$tfID . '" AND 
                                         submitted = "1"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }
}
?>