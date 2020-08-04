<?php
namespace Markaxis\Employee;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Department.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Department extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $edID ) {
        $sql = $this->DB->select( 'SELECT COUNT(edID) FROM employee_department 
                                   WHERE edID = "' . (int)$edID . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID, $dID ) {
        $sql = $this->DB->select( 'SELECT COUNT(edID) FROM employee_department 
                                   WHERE userID = "' . (int)$userID . '" AND
                                         departmentID = "' . (int)$dID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all user roles
     * @return mixed
     */
    public function getByUserID( $userID ) {
        $sql = $this->DB->select( 'SELECT d.dID, d.name FROM employee_department ed
                                   LEFT JOIN department d ON ( d.dID = ed.departmentID )
                                   WHERE userID = "' . (int)$userID . '"',
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
    public function getList( ) {
        $sql = $this->DB->select( 'SELECT * FROM department WHERE deleted <> "1"
                                   ORDER BY name', __FILE__, __LINE__ );

        $list = array( );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['dID']] = $row['name'];
            }
        }
        return $list;
    }


    /**
     * Retrieve a user list normally use for building select list
     * @return mixed
     */
    public function getListByUserID( $userID ) {
        $sql = $this->DB->select( 'SELECT GROUP_CONCAT(DISTINCT departmentID) AS dID 
                                   FROM employee_department
                                   WHERE userID = "' . (int)$userID . '"',
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
    public function getCountList( $dID ) {
        $sql = $this->DB->select( 'SELECT u.userID, u.fname, u.lname, u.email1, u.mobile, n.nationality, e.idnumber,
                                          IFNULL(ed2.department, "" ) AS department, dsg.title AS designation
                                   FROM user u
                                   LEFT JOIN employee e ON ( e.userID = u.userID )
                                   LEFT JOIN employee_department ed ON ( ed.userID = u.userID )
                                   LEFT JOIN nationality n ON ( n.nID = u.nationalityID )                                
                                   LEFT JOIN designation dsg ON ( e.designationID = dsg.dID )
                                   LEFT JOIN ( SELECT userID, GROUP_CONCAT(DISTINCT dpt.name) AS department
                                               FROM employee_department ed
                                               LEFT JOIN department dpt ON ( dpt.dID = ed.departmentID )
                                               WHERE dpt.deleted <> "1"
                                               GROUP BY userID ORDER BY dpt.name ) ed2 ON ed2.userID = u.userID
                                   WHERE u.deleted <> "1" AND e.resigned <> "1" AND 
                                         ed.departmentID = "' . (int)$dID . '"
                                   GROUP BY userID',
                                   __FILE__, __LINE__ );

        $list = array( );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }
}
?>