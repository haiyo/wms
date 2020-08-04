<?php
namespace Aurora\User;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: User.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class User extends \DAO {


    // Properties


    /**
    * Return total count of records
    * @return int
    */
    public function isFound( $userID ) {
        $sql = $this->DB->select( 'SELECT COUNT(userID) FROM user WHERE userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
    * Retrieve all user
    * @return mixed
    */
    public function getAllUser( ) {
        $sql = $this->DB->select( 'SELECT * FROM user ORDER BY fname ASC',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
    * Retrieve a user list normally use for building select list
    * @return mixed
    */
    public function getList( ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT u.userID, CONCAT(u.fname, " ", u.lname ) AS name FROM user
                                   WHERE suspended <> "1" AND deleted <> "1"
                                   ORDER BY name ASC',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['userID']] = $row;
            }
        }
        return $list;
    }


    /**
    * Retrieve a user column by userID
    * @return mixed
    */
    public function getFieldByUserID( $userID, $column ) {
        $sql = $this->DB->select( 'SELECT ' . addslashes( $column ) . ' FROM user u
                                   WHERE u.userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
    * Retrieve a user column by Email
    * @return mixed
    */
    public function getFieldByEmail( $email, $column ) {
        $sql = $this->DB->select( 'SELECT ' . addslashes( $column ) . ' FROM user
                                   WHERE ( email1 = "' . addslashes( $email ) . '" OR 
                                           email2 = "' . addslashes( $email ) . '" )',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve a user column by searching fname and lname
     * @return mixed
     */
    public function getFieldByUsername( $username, $column ) {
        $sql = $this->DB->select( 'SELECT ' . addslashes( $column ) . ' FROM user 
                                   WHERE username = "'. addslashes( $username ) . '"',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve a user column by searching fname and lname
     * @return mixed
     */
    public function getFieldByName( $name, $column ) {
        $sql = $this->DB->select( 'SELECT ' . addslashes( $column ) . ' FROM user 
                                   WHERE CONCAT(fname," ",lname) = "' . addslashes( $name ) . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve a user column by searching fname and lname
     * @return mixed
     */
    public function getListValidCount( $userIDs ) {
        $sql = $this->DB->select( 'SELECT COUNT(*) FROM user
                                   WHERE userID IN(' . addslashes( $userIDs ) . ') AND
                                         suspended <> "1" AND deleted <> "1"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getEvents( $startDate, $endDate ) {
        $sql = $this->DB->select( 'SELECT CONCAT( u.fname, " ", u.lname ) AS name,
                                          CONCAT( YEAR( "' . addslashes( $startDate ) . '" ), "", 
                                                  DATE_FORMAT( u.birthday, "-%m-%d" ) ) AS start
                                   FROM user u 
                                   WHERE MONTH( u.birthday ) >= MONTH( "' . addslashes( $startDate ) . '" ) AND 
                                         MONTH( u.birthday ) <= MONTH( "' . addslashes( $endDate ) . '" ) AND
                                         u.suspended <> "1" AND u.deleted <> "1"',
                                   __FILE__, __LINE__ );

        $list = array( );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $row['classNames'] = 'birthday';
                $list[] = $row;
            }
        }
        return $list;
    }


    /**
     * Retrieve a user column by searching fname and lname
     * @return mixed
     */
    public function searchByName( $name ) {
        $list = array( );
        $sql = $this->DB->select( 'SELECT userID, CONCAT(fname," ",lname) as name FROM user
                                   WHERE CONCAT(fname," ",lname) LIKE "%' . addslashes( $name ) . '%"',
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