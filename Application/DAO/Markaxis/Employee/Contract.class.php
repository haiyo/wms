<?php
namespace Markaxis\Employee;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Contract.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Contract extends \DAO {


    // Properties


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getList( ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT * FROM contract WHERE deleted <> "1"', __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            $list = array( );

            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['cID']] = $row['type'];
            }
        }
        return $list;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getResults( $q='', $order='type ASC' ) {
        $list = array( );

        $q = $q ? addslashes( $q ) : '';
        $q = $q ? 'AND ( c.type LIKE "%' . $q . '%" )' : '';

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS c.cID, c.type, c.descript, IFNULL( e.empCount, 0 ) AS empCount
                                   FROM contract c
                                   LEFT JOIN ( SELECT contractID, COUNT(eID) as empCount FROM employee e
                                               LEFT JOIN user u ON e.userID = u.userID
                                               WHERE u.deleted <> "1" AND e.resigned <> "1" GROUP BY contractID ) e ON e.contractID = c.cID
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
                                   LEFT JOIN nationality n ON ( n.nID = u.nationalityID )
                                   LEFT JOIN designation dsg ON ( e.designationID = dsg.dID )
                                   LEFT JOIN contract cont ON ( e.contractID = cont.cID )
                                   WHERE u.deleted <> "1" AND e.resigned <> "1" AND cont.deleted <> "1" AND 
                                         e.contractID = "' . (int)$cID . '"',
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