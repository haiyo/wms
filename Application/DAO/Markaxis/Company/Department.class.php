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
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getResults( $q='', $order='d.name ASC' ) {
        $q = $q ? addslashes( $q ) : '';
        $q = $q ? 'AND ( d.name LIKE "%' . $q . '%" )' : '';

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS d.dID, d.name, IFNULL( e.empCount, 0 ) AS empCount
                                   FROM department d
                                   LEFT JOIN ( SELECT ed.departmentID, COUNT(eID) as empCount FROM employee e
                                               LEFT JOIN user u ON ( e.userID = u.userID )
                                               LEFT JOIN employee_department ed ON ( ed.userID = u.userID )
                                               WHERE u.deleted <> "1" AND e.resigned <> "1" GROUP BY departmentID ) e ON e.departmentID = d.dID
                                   WHERE d.deleted <> "1" ' . $q . '
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