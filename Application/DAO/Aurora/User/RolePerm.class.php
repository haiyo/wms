<?php
namespace Aurora\User;
use \Application\DAO\DAO;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: RolePerm.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RolePerm extends DAO {


    // Properties


    /**
    * RolePerm Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
	}


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
                                   GROUP_CONCAT(p.permID) AS permIDs FROM role r
                                   LEFT JOIN role_perm rp ON(rp.roleID = r.roleID)
                                   LEFT JOIN permission p ON(rp.permID = p.permID)
                                   GROUP BY r.roleID',
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
                                   INNER JOIN permission p ON(rp.permID = p.permID)
                                   WHERE r.roleID = "' . (int)$roleID . '"',
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