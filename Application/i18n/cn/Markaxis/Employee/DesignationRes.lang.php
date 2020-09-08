<?php
namespace Markaxis\Employee;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: DesignationRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DesignationRes extends Resource {


    // Properties


    /**
     * DesignationRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_DESIGNATION'] = 'Designation';
        $this->contents['LANG_CREATE_NEW_DESIGNATION'] = 'Create New Designation';
        $this->contents['LANG_CREATE_NEW_DESIGNATION_GROUP'] = 'Create New Designation Group';
        $this->contents['LANG_DESIGNATION_GROUP_TITLE'] = 'Designation Group / Title';
        $this->contents['LANG_DELETE_ORPHAN_GROUPS'] = 'Delete Orphan Groups';
        $this->contents['LANG_DELETED_SELECTED_DESIGNATIONS'] = 'Delete Selected Designations';
        $this->contents['LANG_ENTER_GROUP_TITLE'] = 'Enter Group Title';
        $this->contents['LANG_PLEASE_ENTER_GROUP_TITLE'] = 'Please enter a Group Title';
        $this->contents['LANG_NOTE'] = 'Note';
        $this->contents['LANG_DESIGNATION_GROUP_DESCRIPT'] = 'Newly created group will not appear in the table list until a designation has been assigned to it.';
        $this->contents['LANG_DESIGNATION_TITLE'] = 'Designation Title';
        $this->contents['LANG_ENTER_DESIGNATION_TITLE'] = 'Enter Designation Title';
        $this->contents['LANG_ENTER_DESIGNATION_DESCRIPTIONS'] = 'Enter Designation Description';
        $this->contents['LANG_DESIGNATION_GROUP'] = 'Designation Group';
        $this->contents['LANG_EDIT_DESIGNATION'] = 'Edit Designation';
        $this->contents['LANG_SELECT_DESIGNATION_GROUP'] = 'Please select a Designation Group';
        $this->contents['LANG_ENTER_DESIGNATION_TITLE'] = 'Please enter a Designation Title';
        $this->contents['LANG_CREATE_ANOTHER_DESIGNATION'] = 'Create Another Designation';
        $this->contents['LANG_DESIGNATIONS_UNDER_GROUP_DELETED'] = 'All designations under this group will be deleted!';
        $this->contents['LANG_NO_DESIGNATION_SELECTED'] = 'No Designation Selected';
        $this->contents['LANG_DELETE_SELECTED_DESIGNATIONS'] = 'Are you sure you want to delete the selected designations?';
        $this->contents['LANG_DELETE_DESIGNATION'] = 'Delete Designation';
        $this->contents['LANG_CREATE_NEW_GROUP'] = 'Create New Group';
        $this->contents['LANG_CREATE_ANOTHER_GROUP'] = 'Create Another Group';
        $this->contents['LANG_EDIT_GROUP'] = 'Edit Group';
        $this->contents['LANG_DELETE_GROUP'] = 'Delete Group';
        $this->contents['LANG_SEARCH_DESIGNATION'] = 'Search Designation';
        $this->contents['LANG_CONFIRM_DELETE_ALL_ORPHAN_GROUPS'] = 'Are you sure you want to delete all orphan groups?';
        $this->contents['LANG_GROUPS_EMPTY_DESIGNATION_DELETED'] = 'All groups with empty designation will be deleted';
        $this->contents['LANG_ORPHAN_GROUPS_SUCCESSFULLY_DELETE'] = '{count} orphan groups has been successfully deleted!';
        $this->contents['LANG_NO_ORPHAN_GROUPS'] = 'There are currently no orphan group.';
    }
}
?>