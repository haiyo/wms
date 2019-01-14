<?php
namespace Aurora\User;
use \Library\IO\File;
use \Validator, \IsEmpty, \ValidatorException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: RolePermModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RolePermModel extends Model {


    // Properties


    /**
    * RolePermModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/RolePermRes');
	}


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $roleID, $permID ) {
        File::import( DAO . 'Aurora/User/RolePerm.class.php' );
        $RolePerm = new RolePerm( );
        return $RolePerm->isFound( $roleID, $permID );
    }


    /**
    * Return all roles with permissions
    * @return mixed
    */
    public function getAll( ) {
        File::import( DAO . 'Aurora/User/RolePerm.class.php' );
        $RolePerm = new RolePerm( );
        return $RolePerm->getAll( );
    }


    /**
    * Return all roles by one or more IDs
    * @return mixed
    */
    public function getByRoleID( $roleID ) {
        File::import( DAO . 'Aurora/User/RolePerm.class.php' );
        $RolePerm = new RolePerm( );
        return $RolePerm->getByRoleID( $roleID );
    }


    /**
    * Save Role Permissions
    * @return void
    */
    public function savePerms( $data ) {
        File::import( MODEL . 'Aurora/User/RoleModel.class.php' );
        $RoleModel = new RoleModel( );

        File::import( DAO . 'Aurora/User/RolePerm.class.php' );
        $RolePerm = new RolePerm( );

        if( $data['roleID'] > 1 ) {
            if( isset( $data['perms'] ) && is_array( $data['perms'] ) &&
                isset( $data['roleID'] ) && $data['roleID'] > 1 ) {

                foreach( $data['perms'] as $permID ) {
                    if( $RoleModel->isFound( $data['roleID'] ) && !$this->isFound( $data['roleID'], $permID ) ) {
                        $permSet = array( );
                        $permSet['roleID'] = (int)$data['roleID'];
                        $permSet['permID'] = (int)$permID;
                        $RolePerm->insert( 'role_perm', $permSet );
                    }
                }
                $RolePerm->delete( 'role_perm', 'WHERE roleID = "' . (int)$data['roleID'] . '" AND 
                                    permID NOT IN(' . addslashes( implode( ',', $data['department'] ) ) . ')' );
            }
        }
    }


    /**
    * Set Role Info
    * @return bool
    */
    public function setInfo( $info ) {
        File::import( LIB . 'Validator/Validator.dll.php' );
        File::import( LIB . 'Validator/ValidatorModule/IsEmpty.dll.php' );
        $Validator = new Validator( );
        $this->info['roleID']   = (int)$info['roleID'];
        $this->info['title']    = Validator::htmlTrim( $info['title'] );
        $this->info['descript'] = Validator::htmlTrim( $info['descript'] );
        $Validator->addModule( 'title', new IsEmpty( $this->info['title'] ) );

        try {
            $Validator->validate( );
        }
        catch( ValidatorException $e ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_ROLE_TITLE_EMPTY') );
            return false;
        }
        return true;
    }


    /**
    * Save Role Permissions
    * @return void
    */
    public function saveInfo( ) {
        File::import( DAO . 'Aurora/User/Role.class.php' );
        $Role = new Role( );

        if( $this->info['roleID'] == 0 ) {
            unset( $this->info['roleID'] );
            $this->info['created'] = date( 'Y-m-d H:i:s' );
            $this->info['roleID'] = $Role->insert( 'role', $this->info );
        }
        else {
            $Role->update( 'role', $this->info, 'WHERE roleID="' . (int)$this->info['roleID'] . '"' );
        }
    }


    /**
    * Delete Role
    * @return void
    */
    public function delete( $roleID ) {
        File::import( DAO . 'Aurora/User/Role.class.php' );
        $Role = new Role( );
        return $Role->delete( 'role', 'WHERE roleID="' . (int)$roleID . '"' );
    }
}
?>