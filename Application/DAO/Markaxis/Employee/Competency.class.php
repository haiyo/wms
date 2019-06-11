<?php
namespace Markaxis\Employee;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Component.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Competency extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID, $cID ) {
        $sql = $this->DB->select( 'SELECT COUNT(cID) FROM employee_competency 
                                   WHERE userID = "' . (int)$userID . '" AND
                                         cID = "' . (int)$cID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getBycID( $cID ) {
        $sql = $this->DB->select( 'SELECT * FROM competency c
                                   WHERE c.cID = "' . (int)$cID . '" AND
                                         c.deleted <> "1"',
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
    public function getByUserID( $userID ) {
        $sql = $this->DB->select( 'SELECT GROUP_CONCAT(c.competency SEPARATOR ";") AS competency 
                                   FROM employee_competency ec
                                   LEFT JOIN competency c ON ( c.cID = ec.cID )
                                   WHERE ec.userID = "' . (int)$userID . '" AND
                                         c.deleted <> "1"',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getCountList( $cID ) {
        $sql = $this->DB->select( 'SELECT u.userID, u.fname, u.lname, u.email1, n.nationality, e.idnumber,
                                          dpt.name AS department, dsg.title AS designation
                                   FROM user u
                                   LEFT JOIN employee e ON ( e.userID = u.userID )
                                   LEFT JOIN employee_department e_dpt ON ( e_dpt.userID = u.userID )
                                   LEFT JOIN department dpt ON ( e_dpt.departmentID = dpt.dID )
                                   LEFT JOIN employee_competency ec ON ( ec.userID = u.userID )
                                   LEFT JOIN nationality n ON ( n.nID = u.nationalityID )
                                   LEFT JOIN designation dsg ON ( e.designationID = dsg.dID )
                                   WHERE u.deleted <> "1" AND e.resigned <> "1" AND ec.cID = "' . (int)$cID . '"',
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
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getResults( $q='', $order='competency ASC' ) {
        $list = array( );

        $q = $q ? addslashes( $q ) : '';
        $q = $q ? 'AND ( c.competency LIKE "%' . $q . '%" )' : '';

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS c.cID, c.competency, c.descript, IFNULL( ec.empCount, 0 ) AS empCount
                                   FROM competency c
                                   LEFT JOIN ( SELECT cID, COUNT(ecID) as empCount FROM employee_competency ec
                                               LEFT JOIN user u ON ( u.userID = ec.userID )
                                               LEFT JOIN employee e ON ( e.userID = u.userID )
                                               WHERE u.deleted <> "1" AND e.resigned <> "1" GROUP BY cID ) ec ON ec.cID = c.cID
                                   WHERE c.deleted <> "1" ' . $q . '
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