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
}
?>