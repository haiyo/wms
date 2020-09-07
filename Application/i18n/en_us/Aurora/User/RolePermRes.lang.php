<?php
namespace Aurora\User;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: RolePermRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RolePermRes extends Resource {


    /**
    * RolePermRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        
        $this->contents = array( );
        $this->contents['LANG_ROLES_PERMISSIONS'] = 'Roles &amp; Permissions';
        $this->contents['LANG_CREATE_NEW_ROLE'] = 'Create New Role';
        $this->contents['LANG_DELETE_ROLE'] = 'Delete Role';
        $this->contents['LANG_SAVE'] = 'Save Settings';
        $this->contents['LANG_CONFIRM_CLOSE'] = 'You have not save your changes to the permission settings. Are you sure you want to cancel?';
        $this->contents['LANG_PERMISSION_SAVED'] = 'Permissions has been saved.';
        $this->contents['LANG_NO_DATA_SAVED'] = 'You have not make any changes to the permission settings. No data has been save.';
        $this->contents['LANG_CONFIRM_DELETE_ROLE'] = 'Are you sure you want to delete the {roleTitle} role?';
        $this->contents['LANG_ROLE_TITLE_EMPTY'] = 'Please enter a role title.';
        $this->contents['LANG_NEW_ROLE'] = 'New Role';
        $this->contents['LANG_ROLE_NAME'] = 'Role Name';
        $this->contents['LANG_ROLE_TITLE'] = 'Role Title';
        $this->contents['LANG_ENTER_ROLE_TITLE'] = 'Enter Role Title';
        $this->contents['LANG_ROLE_DESCRIPTION'] = 'Role Description';
        $this->contents['LANG_ENTER_ROLE_DESCRIPTION'] = 'Enter Role Description';
        $this->contents['LANG_DEFINE_PERMISSIONS'] = 'Define Permissions';
        $this->contents['LANG_SAVE_PERMISSIONS'] = 'Save Permissions';

        $this->contents['LANG_EDIT_ROLE'] = 'Edit Role';
        $this->contents['LANG_CREATE_ANOTHER_ROLE'] = 'Create Another Role';
        $this->contents['LANG_PERMISSIONS_SAVED'] = 'Permissions saved!';
        $this->contents['LANG_SEARCH_ROLE_NAME'] = 'Search Role Name';
	}
}
?>