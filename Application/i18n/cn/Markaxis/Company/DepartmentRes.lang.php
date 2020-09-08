<?php
namespace Markaxis\Company;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: DepartmentRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DepartmentRes extends Resource {


    // Properties


    /**
     * DepartmentRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_DEPARTMENT'] = 'Department';
        $this->contents['LANG_CREATE_NEW_DEPARTMENT'] = 'Create New Department';
        $this->contents['LANG_DEPARTMENT_NAME'] = 'Department Name';
        $this->contents['LANG_MANAGERS'] = 'Manager(s)';
        $this->contents['LANG_ENTER_DEPARTMENT_NAME'] = 'Enter Department Name';
        $this->contents['LANG_DEPARTMENT_MANAGER'] = 'Department Manager(s)';
        $this->contents['LANG_ENTER_MANAGER_NAME'] = 'Enter Manager\'s Name';
        $this->contents['LANG_EDIT_DEPARTMENT'] = 'Edit Department';
        $this->contents['LANG_ENTER_DEPARTMENT_NAME'] = 'Please enter a Department Name';
        $this->contents['LANG_ENTER_VALID_MANAGER'] = 'Please enter a valid manager';
        $this->contents['LANG_CREATE_ANOTHER_DEPARTMENT'] = 'Create Another Department';
        $this->contents['LANG_DELETE_DEPARTMENT'] = 'Delete Department';
        $this->contents['LANG_SEARCH_DEPARTMENT'] = 'Search Department';
    }
}
?>