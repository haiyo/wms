<?php
namespace Aurora\User;
use \Library\Validator\Validator, \Library\Validator\ValidatorModule\IsEmail;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: UserRoleModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserRoleModel extends \Model {


    // Properties
    protected $UserRole;


    /**
    * UserRoleModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->UserRole = new UserRole( );
	}


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID, $roleID ) {
        return $this->UserRole->isFoundByUserID( $userID, $roleID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getCountList( $roleID ) {
        $list = $this->UserRole->getCountList( $roleID );

        if( sizeof( $list ) > 0 ) {
            $UserImageModel = UserImageModel::getInstance( );

            foreach( $list as $key => $value ) {
                $list[$key]['image'] = $UserImageModel->getByUserID( $list[$key]['userID'], 'up.hashDir, up.hashName');
            }
        }
        return $list;
    }


    /**
    * Return a list of all users
    * @return mixed
    */
    public function getByUserID( $userID ) {
        return $this->UserRole->getByUserID( $userID );
    }


    /**
    * Return all userID by roleID
    * @return mixed
    */
    public function getByRoleID( $roleID ) {
        return $this->UserRole->getByRoleID( $roleID );
    }


    /**
    * Return a list of all users
    * $exclude Array of userIDs
    * @return mixed
    */
    public function getUsers( $currPage=1, $limit=10, $exclude=false ) {
        $this->UserRole->setLimit( $currPage, $limit );
        return $this->UserRole->getUserExcludeIDs( $exclude );
    }


    /**
    * Return a list of all users by name or email with roleID
    * @return mixed
    */
    public function searchByNameEmail( $q, $roleID, $currPage=1, $limit=10, $exclude=false ) {
        $this->UserRole->setLimit( $currPage, $limit );

        $Validator = new Validator( );
        $Email = new IsEmail( $q );
        if( $Email->validate( ) ) {
            return $this->UserRole->searchByEmailRole( $q, $roleID, $exclude );
        }
        else {
            return $this->UserRole->searchByNameRole( $q, $roleID, $exclude );
        }
    }


    /**
     * Add roles to user
     * @return void
     */
    public function save( $data ) {
        $Role = new Role( );

        if( isset( $data['role'] ) && is_array( $data['role'] ) && isset( $data['userID'] ) && $data['userID'] ) {
            $validRoleID = array( );

            foreach( $data['role'] as $value ) {
                if( $Role->isFound( $value ) ) {
                    if( !$this->isFoundByUserID( $data['userID'], $value ) ) {
                        $info = array( );
                        $info['userID'] = (int)$data['userID'];
                        $info['roleID'] = (int)$value;
                        $this->UserRole->insert( 'user_role', $info );
                    }
                    array_push( $validRoleID, $value );
                }
            }
            $role = implode( ',', $validRoleID );

            if( $role ) {
                $this->UserRole->delete( 'user_role', 'WHERE userID = "' . (int)$data['userID'] . '" AND 
                                                roleID NOT IN(' . addslashes( $role ) . ')' );
            }
        }
    }



    /**
    * Add roles to user
    * @return void
    */
    public function addUserRoles( $userID, $roles ) {
        if( is_array( $roles ) ) {

            foreach( $roles as $roleID ) {
                if( is_numeric( $roleID ) ) {
                    $info = array( );
                    $info['userID'] = (int)$userID;
                    $info['roleID'] = (int)$roleID;
                    $this->UserRole->insert( 'user_role', $info );
                }
            }
        }
    }


    /**
    * Delete All Roles from user
    * @return bool
    */
    public function deleteUserRoles( $userID ) {
        return $this->UserRole->delete( 'user_role', 'WHERE userID="' . (int)$userID . '"' );
    }
}
?>