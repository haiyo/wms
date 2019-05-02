<?php
namespace Markaxis\Company;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Department.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Department extends \DAO {


    // Properties


    /**
     * Department Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getResults( $q='', $order='d.name ASC' ) {
        $list = array( );

        $q = $q ? addslashes( $q ) : '';
        $q = $q ? 'AND ( d.name LIKE "%' . $q . '%" )' : '';

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS d.dID, d.name, IFNULL( ed.empCount, 0 ) AS empCount
                                   FROM department d
                                   LEFT JOIN ( SELECT departmentID, COUNT(edID) as empCount FROM employee_department ed
                                               LEFT JOIN user u ON ( ed.userID = u.userID )
                                               LEFT JOIN employee e ON ( e.userID = u.userID )
                                               WHERE u.deleted <> "1" AND e.resigned <> "1" GROUP BY departmentID ) ed ON ed.departmentID = d.dID
                                   WHERE d.deleted <> "1" ' . $q . '
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
     * @return mixed
     */
    public function getCountList( $dID ) {
        $sql = $this->DB->select( 'SELECT u.userID, u.fname, u.lname, u.email1, n.nationality, e.idnumber,
                                          dpt.name AS department, dsg.title AS designation
                                   FROM user u
                                   LEFT JOIN employee e ON ( e.userID = u.userID )
                                   LEFT JOIN employee_department e_dpt ON ( e_dpt.userID = u.userID )
                                   LEFT JOIN department dpt ON ( e_dpt.departmentID = dpt.dID )
                                   LEFT JOIN nationality n ON ( n.nID = u.nationalityID )                                
                                   LEFT JOIN designation dsg ON ( e.designationID = dsg.dID )
                                   WHERE u.deleted <> "1" AND e.resigned <> "1" AND dpt.deleted <> "1" AND 
                                         e_dpt.departmentID = "' . (int)$dID . '"',
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