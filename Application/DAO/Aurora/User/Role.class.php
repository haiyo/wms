<?php
namespace Aurora\User;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: Role.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Role extends \DAO {


    // Properties


    /**
    * Role Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
	}


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $roleID ) {
        $sql = $this->DB->select( 'SELECT COUNT(roleID) FROM role WHERE roleID = "' . (int)$roleID . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
    * Return Role list used for select list
    * @return mixed
    */
    public function getList( ) {
        $list = array( );
        $sql = $this->DB->select( 'SELECT roleID, title FROM role',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['roleID']] = $row['title'];
       	    }
        }
        return $list;
    }


    /**
    * Return role information by roleID
    * @return mixed
    */
    public function getByRoleID( $roleID ) {
        $list = array( );
        $sql = $this->DB->select( 'SELECT * FROM role WHERE roleID = "' . (int)$roleID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }
}
?>