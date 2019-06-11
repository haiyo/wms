<?php
namespace Markaxis\Company;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: DepartmentManager.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DepartmentManager extends \DAO {


    // Properties


    /**
     * Retrieve all user roles
     * @return mixed
     */
    public function getBydID( $dID ) {
        $sql = $this->DB->select( 'SELECT dm.userID AS managerID, CONCAT(u.fname, " ", u.lname ) AS name 
                                   FROM department_manager dm
                                   LEFT JOIN user u ON ( u.userID = dm.userID )
                                   WHERE departmentID = "' . (int)$dID . '"',
                                   __FILE__, __LINE__ );

        $list = array( );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['managerID']] = $row;
            }
        }
        return $list;
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getCountList( $dID ) {
        $sql = $this->DB->select( 'SELECT u.userID, u.fname, u.lname, u.email1, n.nationality, e.idnumber,
                                          dpt.name AS department, dsg.title AS designation
                                   FROM user u
                                   LEFT JOIN employee e ON ( e.userID = u.userID )
                                   LEFT JOIN nationality n ON ( n.nID = u.nationalityID )
                                   LEFT JOIN department dpt ON ( e.departmentID = dpt.dID )
                                   LEFT JOIN designation dsg ON ( e.designationID = dsg.dID )
                                   WHERE u.deleted <> "1" AND e.resigned <> "1" AND dpt.deleted <> "1" AND 
                                         e.departmentID = "' . (int)$dID . '"',
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