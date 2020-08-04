<?php
namespace Markaxis\Employee;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Office.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Office extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return mixed
     */
    public function getCountList( $oID ) {
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
                                         e.officeID = "' . (int)$oID . '" 
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