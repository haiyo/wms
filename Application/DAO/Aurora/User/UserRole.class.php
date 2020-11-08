<?php
namespace Aurora\User;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: UserRole.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserRole extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID, $roleID ) {
        $sql = $this->DB->select( 'SELECT COUNT(*) FROM user_role 
                                   WHERE userID = "' . (int)$userID . '" AND
                                         roleID = "' . (int)$roleID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getCountList( $roleID ) {
        $sql = $this->DB->select( 'SELECT u.userID, u.fname, u.lname, u.email, u.mobile, n.nationality, e.idnumber,
                                          IFNULL(ed.department, "" ) AS department, dsg.title AS designation
                                   FROM user u
                                   LEFT JOIN employee e ON ( e.userID = u.userID )
                                   LEFT JOIN user_role ur ON ( ur.userID = u.userID )
                                   LEFT JOIN nationality n ON ( n.nID = u.nationalityID )
                                   LEFT JOIN designation dsg ON ( e.designationID = dsg.dID )
                                   LEFT JOIN ( SELECT userID, GROUP_CONCAT(DISTINCT dpt.name) AS department
                                               FROM employee_department ed
                                               LEFT JOIN department dpt ON ( dpt.dID = ed.departmentID )
                                               WHERE dpt.deleted <> "1"
                                               GROUP BY userID ORDER BY dpt.name ) ed ON ed.userID = e.userID
                                   WHERE u.deleted <> "1" AND e.resigned <> "1" AND 
                                         ur.roleID = "' . (int)$roleID . '"
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


    /**
     * Retrieve all user roles
     * @return mixed
     */
    public function getByUserID( $userID ) {
        $list = array( );
        $sql = $this->DB->select( 'SELECT * FROM user_role 
                                   WHERE userID = "' . (int)$userID . '"',
            __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row['roleID'];
            }
        }
        return $list;
    }


    /**
    * Retrieve all user in the $userIDs range
    * @return mixed
    */
    public function getUserOnIDs( $userIDs ) {
        $exclude = is_array( $userIDs ) ? ' WHERE u.userID IN(' . addslashes( implode( ',', $userIDs ) ) . ')' : '';
        return $this->getUser( $exclude );
    }


    /**
    * Retrieve all user roles where not in the $userIDs range
    * @return mixed
    */
    public function getUserExcludeIDs( $userIDs ) {
        $exclude = is_array( $userIDs ) ? ' WHERE u.userID NOT IN(' . addslashes( implode( ',', $userIDs ) ) . ')' : '';
        return $this->getUser( $exclude );
    }


    /**
    * Retrieve all user roles
    * @return mixed
    */
    public function getUser( $extra='' ) {
        $list = array( );
        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS u.userID, u.fname, u.lname, u.email, u.gender,
                                          u.jobTitle, u.status, ul.isOnline, ua.name, ua.hashName, ua.hashDir,
                                          ua.size,
                                          GROUP_CONCAT(r.roleID) as roleIDs,
                                          GROUP_CONCAT(r.title) AS roleTitle
                                   FROM user u 
                                          JOIN user_log ul ON(u.userID = ul.userID)
                                          LEFT OUTER JOIN user_avatar ua ON(ua.userID = u.userID)
                                          LEFT OUTER JOIN user_role ur ON(u.userID = ur.userID)
                                          LEFT OUTER JOIN role r ON(ur.roleID = r.roleID)
                                          LEFT OUTER JOIN user_role urd ON (urd.userID = u.userID)
                                          ' . addslashes( $extra ) . '
                                   GROUP BY u.userID
                                   ORDER BY u.fname' . $this->limit,
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
       	    }
        }
        $sql = $this->DB->select( 'SELECT FOUND_ROWS()', __FILE__, __LINE__ );
        $row = $this->DB->fetch( $sql );
        $list['total'] = $row['FOUND_ROWS()'];
        return $list;
    }


    /**
    * Retrieve all user by name and role
    * @return mixed
    */
    public function searchByNameRole( $q, $roleID, $exclude=false ) {
        $q = $q ? 'CONCAT(fname," ",lname) LIKE "%' . addslashes( $q ) . '%"' : '';
        return $this->search( $q, $roleID, $exclude );
    }


    /**
    * Retrieve all user by name and role
    * @return mixed
    */
    public function searchByEmailRole( $q, $roleID, $exclude=false ) {
        $q = $q ? 'email LIKE "%' . addslashes( $q ) . '%"' : '';
        return $this->search( $q, $roleID, $exclude );
    }


    /**
    * Retrieve all user by name and role
    * @return mixed
    */
    public function search( $q, $roleID, $exclude=false ) {
        $list = array( );
        $role = '';
        $excludeUser = '';
        
        if( $roleID > 0 ) {
            if( $q ) { $role .= ' AND '; }
            $role .= 'r.roleID = "' . (int)$roleID . '"';
        }
        if( is_array( $exclude ) ) {
            $excludeUser = 'u.userID NOT IN(' . addslashes( implode( ',', $exclude ) ) . ')';
            if( $q || $role ) { $excludeUser = ' AND ' . $excludeUser; }
        }
        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS u.userID, u.fname, u.lname, u.email, u.gender,
                                          u.jobTitle, u.status, ul.isOnline, ua.name, ua.hashName, ua.hashDir,
                                          ua.size,
                                          GROUP_CONCAT(r.roleID) as roleIDs,
                                          GROUP_CONCAT(r.title) AS roleTitle
                                   FROM user u 
                                          JOIN user_log ul ON(u.userID = ul.userID)
                                          LEFT OUTER JOIN user_avatar ua ON(ua.userID = u.userID)
                                          LEFT OUTER JOIN user_role ur ON(u.userID = ur.userID)
                                          LEFT OUTER JOIN role r ON(ur.roleID = r.roleID)
                                          LEFT OUTER JOIN user_role urd ON (urd.userID = u.userID)
                                   WHERE ' . $q . '
                                         ' . $role . '
                                         ' . $excludeUser . '
                                   GROUP BY u.userID
                                   ORDER BY u.fname' . $this->limit,
                                   __FILE__, __LINE__ );
        
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
       	    }
        }
        $sql = $this->DB->select( 'SELECT FOUND_ROWS()', __FILE__, __LINE__ );
        $row = $this->DB->fetch( $sql );
        $list['total'] = $row['FOUND_ROWS()'];
        return $list;
    }


    /**
    * Retrieve all users by roleID
    * @return mixed
    */
    public function getByRoleID( $roleID ) {
        $list = array( );
        $sql = $this->DB->select( 'SELECT u.userID, u.fname, u.lname, u.email, u.gender,
                                          u.status, ul.isOnline, ua.name, ua.hashName, ua.hashDir,
                                          ua.size, GROUP_CONCAT(r.title) AS roleTitle
                                   FROM user u
                                          JOIN user_log ul ON(u.userID = ul.userID)
                                          LEFT OUTER JOIN user_avatar ua ON(ua.userID = u.userID)
                                          LEFT OUTER JOIN user_role ur ON(u.userID = ur.userID)
                                          LEFT OUTER JOIN role r ON(ur.roleID = r.roleID)
                                   WHERE ur.roleID = "' . (int)$roleID . '"
                                          GROUP BY u.userID
                                          ORDER BY u.fname',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
       	    }
        }
        return $list;
    }
}
?>