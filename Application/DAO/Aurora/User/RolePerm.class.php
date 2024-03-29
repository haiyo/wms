<?php
namespace Aurora\User;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: RolePerm.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RolePerm extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $roleID, $permID ) {
        $sql = $this->DB->select( 'SELECT COUNT(rpID) FROM role_perm
                                   WHERE roleID = "' . (int)$roleID . '" AND
                                         permID = "' . (int)$permID . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
    * Retrieve all roles with permissons
    * @return mixed
    */
    public function getAll( ) {
        $list = array( );
        $sql = $this->DB->select( 'SELECT r.roleID, r.title, r.descript, 
                                   GROUP_CONCAT(p.pID) AS permIDs FROM role r
                                   LEFT JOIN role_perm rp ON(rp.roleID = r.roleID)
                                   LEFT JOIN permission p ON(rp.permID = p.pID)
                                   GROUP BY r.roleID ORDER BY p.sorting',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }


    /**
    * Retrieve all roles with permissons
    * @return mixed
    */
    public function getByRoleID( $roleID ) {
        $list = array( );
        $sql = $this->DB->select( 'SELECT * FROM role r
                                   INNER JOIN role_perm rp ON(rp.roleID = r.roleID)
                                   INNER JOIN permission p ON(rp.permID = p.pID)
                                   WHERE r.roleID = "' . (int)$roleID . '"',
                                   __FILE__, __LINE__ );

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
    public function getResults( $q='', $order='r.title ASC' ) {
        $list = array( );

        $q = $q ? addslashes( $q ) : '';
        $q = $q ? 'AND ( r.title LIKE "%' . $q . '%" )' : '';

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS r.roleID, r.title, r.descript, IFNULL( e.empCount, 0 ) AS empCount
                                   FROM role r
                                   LEFT JOIN ( SELECT ur.roleID AS roleID, COUNT(eID) as empCount FROM employee e
                                               LEFT JOIN user u ON e.userID = u.userID
                                               LEFT JOIN user_role ur ON ur.userID = u.userID
                                               WHERE u.deleted <> "1" AND e.resigned <> "1" GROUP BY ur.roleID ) e ON e.roleID = r.roleID
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
}
?>