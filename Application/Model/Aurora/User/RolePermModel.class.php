<?php
namespace Aurora\User;
use \Library\Validator\Validator;
use \Library\Validator\ValidatorModule\IsEmpty;
use \Library\Exception\ValidatorException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: RolePermModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RolePermModel extends \Model {


    // Properties
    protected $Role;
    protected $RolePerm;


    /**
    * RolePermModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/RolePermRes');

        $this->Role = new Role( );
        $this->RolePerm = new RolePerm( );
	}


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $roleID, $permID ) {
        return $this->RolePerm->isFound( $roleID, $permID );
    }


    /**
    * Return all roles with permissions
    * @return mixed
    */
    public function getAll( ) {
        return $this->RolePerm->getAll( );
    }


    /**
    * Return all roles by one or more IDs
    * @return mixed
    */
    public function getByRoleID( $roleID ) {
        return $this->RolePerm->getByRoleID( $roleID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        $this->RolePerm->setLimit( $post['start'], $post['length'] );

        $order = 'r.title';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'r.title';
                    break;
            }
        }
        $results = $this->RolePerm->getResults( $post['search']['value'], $order . $dir );

        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$post['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }


    /**
    * Save Role Permissions
    * @return void
    */
    public function savePerms( $data ) {
        $RoleModel = new RoleModel( );

        if( isset( $data['roleID'] ) && $RoleModel->isFound( $data['roleID'] ) ) {
            if( isset( $data['perms'] ) && is_array( $data['perms'] ) ) {
                $validpID  = array( );

                foreach( $data['perms'] as $permID ) {
                    if( !$this->isFound( $data['roleID'], $permID ) ) {
                        $permSet = array( );
                        $permSet['roleID'] = (int)$data['roleID'];
                        $permSet['permID'] = (int)$permID;
                        $this->RolePerm->insert( 'role_perm', $permSet );
                    }
                    array_push( $validpID, $permID );
                }
                $permIDs = implode( ',', $validpID );
                $this->RolePerm->delete('role_perm','WHERE roleID = "' . (int)$data['roleID'] . '" AND 
                                                           permID NOT IN(' . addslashes( $permIDs ) . ')' );
            }
            else {
                $this->RolePerm->delete('role_perm','WHERE roleID = "' . (int)$data['roleID'] . '"' );
            }
        }
    }


    /**
    * Set Role Info
    * @return bool
    */
    public function setInfo( $info ) {
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
        if( $this->info['roleID'] == 0 ) {
            unset( $this->info['roleID'] );
            $this->info['created'] = date( 'Y-m-d H:i:s' );
            $this->info['roleID'] = $this->Role->insert( 'role', $this->info );
        }
        else {
            $this->Role->update( 'role', $this->info, 'WHERE roleID="' . (int)$this->info['roleID'] . '"' );
        }
    }


    /**
    * Delete Role
    * @return void
    */
    public function delete( $roleID ) {
        return $this->Role->delete( 'role', 'WHERE roleID="' . (int)$roleID . '"' );
    }
}
?>