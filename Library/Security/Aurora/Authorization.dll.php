<?php
namespace Library\Security\Aurora;
use \Aurora\User\UserRoleModel;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: Authorization.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Authorization {


    // Properties
    protected $UserRoleModel;
    protected $RolePermModel;
    protected $roleInfo;
    protected $rpInfo;
    protected $namespace;
    protected $action;


    /**
    * Authorization Constructor
    * @return void
    */
    function __construct( ) {
        $this->roleInfo = array( );
        $this->rpInfo = array( );
        $this->namespace = NULL;
        $this->action = NULL;
	}


    /**
    * Return the last requested operation
    * @return str
    */
    public function getLastOperation( ) {
        return 'Namespace: ' . $this->namespace . '; Operation: ' . $this->action . ';';
    }


    /**
    * Load all user roles and permissions
    * @return void
    */
    public function load( $userID ) {
        File::import( MODEL . 'Aurora/User/UserRoleModel.class.php' );
        $this->UserRoleModel = new UserRoleModel( );
        $this->roleInfo = $this->UserRoleModel->getByUserID( $userID );

        if( !in_array( 1, $this->roleInfo ) ) {
            File::import( MODEL . 'Aurora/User/RolePermModel.class.php' );
            $this->RolePermModel = new RolePermModel( );
            while( list( , $roleID ) = each( $this->roleInfo ) ) {
                $info = $this->RolePermModel->getByRoleID( $roleID );
                if( sizeof( $info ) > 0 ) {
                    while( list( , $row ) = each( $info ) ) {
                        $this->rpInfo[$row['namespace']][] = $row['action'];
                    }
                }
            }
        }
    }


    /**
    * Return if current user is admin
    * @return bool
    */
    public function isAdmin( ) {
        if( in_array( 1, $this->roleInfo ) ) {
            return true;
        }
        return false;
    }


    /**
    * Return true if found role exist in parameter given.
    * @return bool
    */
    public function hasAnyRole( $role ) {
        if( is_array( $role ) ) {
            while( list( , $roleID ) = each( $role ) ) {
                if( in_array( $roleID, $this->roleInfo ) ) {
                    return true;
                }
            }
        }
        else {
            if( in_array( $role, $this->roleInfo ) ) {
                return true;
            }
        }
        return false;
    }


    /**
    * Return permission on specific namespace and action
    * @return bool
    */
    public function hasPermission( $namespace, $action ) {
        // Cache for last operation
        $this->namespace = $namespace;
        $this->action = $action;

        if( $this->isAdmin( ) || in_array( $action, $this->rpInfo[$namespace] ) ) {
            return true;
        }
        return false;
    }
}
?>