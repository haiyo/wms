<?php
namespace Aurora\User;

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
}
?>