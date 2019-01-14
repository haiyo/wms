<?php
namespace Aurora\User;
use \Library\IO\File;
use \Validator, \IsEmail;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: UserRoleModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserRoleModel extends \Model {


    // Properties
    


    /**
    * UserRoleModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');
	}


    /**
    * Return a list of all users
    * @return mixed
    */
    public function getByUserID( $userID ) {
        File::import( DAO . 'Aurora/User/UserRole.class.php' );
        $UserRole = new UserRole( );
        return $UserRole->getByUserID( $userID );
    }


    /**
    * Return all userID by roleID
    * @return mixed
    */
    public function getByRoleID( $roleID ) {
        File::import( DAO . 'Aurora/User/UserRole.class.php' );
        $UserRole = new UserRole( );
        return $UserRole->getByRoleID( $roleID );
    }


    /**
    * Return a list of all users
    * $exclude Array of userIDs
    * @return mixed
    */
    public function getUsers( $currPage=1, $limit=10, $exclude=false ) {
        File::import( DAO . 'Aurora/User/UserRole.class.php' );
        $UserRole = new UserRole( );
        $UserRole->setLimit( $currPage, $limit );
        return $UserRole->getUserExcludeIDs( $exclude );
    }


    /**
    * Return a list of all users by name or email with roleID
    * @return mixed
    */
    public function searchByNameEmail( $q, $roleID, $currPage=1, $limit=10, $exclude=false ) {
        File::import( DAO . 'Aurora/User/UserRole.class.php' );
        $UserRole = new UserRole( );
        $UserRole->setLimit( $currPage, $limit );

        File::import( LIB . 'Validator/Validator.dll.php' );
        File::import( LIB . 'Validator/ValidatorModule/IsEmail.dll.php' );
        $Validator = new Validator( );
        $Email = new IsEmail( $q );
        if( $Email->validate( ) ) {
            return $UserRole->searchByEmailRole( $q, $roleID, $exclude );
        }
        else {
            return $UserRole->searchByNameRole( $q, $roleID, $exclude );
        }
    }


    /**
     * Add roles to user
     * @return void
     */
    public function save( $data ) {
        File::import( DAO . 'Aurora/User/Role.class.php' );
        $Role = new Role( );

        if( isset( $data['role'] ) && is_array( $data['role'] ) &&
            isset( $data['userID'] ) && $data['userID'] ) {
            File::import( DAO . 'Aurora/User/UserRole.class.php' );
            $UserRole = new UserRole( );

            foreach( $data['role'] as $value ) {
                if( $Role->isFound( $value ) ) {
                    $info = array( );
                    $info['userID'] = (int)$data['userID'];
                    $info['roleID'] = (int)$value;
                    $UserRole->insert( 'user_role', $info );
                }
            }
            $UserRole->delete( 'user_role', 'WHERE userID = "' . (int)$data['userID'] . '" AND 
                                            roleID NOT IN(' . addslashes( implode( ',', $data['role'] ) ) . ')' );
        }
    }


    /**
    * Add roles to user
    * @return void
    */
    public function addUserRoles( $userID, $roles ) {
        if( is_array( $roles ) ) {
            File::import( DAO . 'Aurora/User/UserRole.class.php' );
            $UserRole = new UserRole( );

            foreach( $roles as $roleID ) {
                if( is_numeric( $roleID ) ) {
                    $info = array( );
                    $info['userID'] = (int)$userID;
                    $info['roleID'] = (int)$roleID;
                    $UserRole->insert( 'user_role', $info );
                }
            }
        }
    }


    /**
    * Delete All Roles from user
    * @return bool
    */
    public function deleteUserRoles( $userID ) {
        File::import( DAO . 'Aurora/User/UserRole.class.php' );
        $UserRole = new UserRole( );
        return $UserRole->delete( 'user_role', 'WHERE userID="' . (int)$userID . '"' );
    }
}
?>