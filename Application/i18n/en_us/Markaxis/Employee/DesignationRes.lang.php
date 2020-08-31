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
        $this->contents['LANG_BULK_ACTION'] = 'Bulk Action';
        $this->contents['LANG_DESCRIPTION'] = 'Description';
        $this->contents['LANG_NO_OF_EMPLOYEE'] = 'No. of Employee';
        $this->contents['LANG_ACTIONS'] = 'Actions';
        $this->contents['LANG_CANCEL'] = 'Cancel';
        $this->contents['LANG_SUBMIT'] = 'Submit';
        $this->contents['LANG_DELETE_ORPHAN_GROUPS'] = 'Delete Orphan Groups';
        $this->contents['LANG_DELETED_SELECTED_DESIGNATIONS'] = 'Delete Selected Designations';
        $this->contents['LANG_ENTER_GROUP_TITLE'] = 'Enter Group Title';
        $this->contents['LANG_NOTE'] = 'Note';
        $this->contents['LANG_DESIGNATION_GROUP_DESCRIPT'] = 'Newly created group will not appear in the table list until a designation has been assigned to it.';
        $this->contents['LANG_DESIGNATION_TITLE'] = 'Designation Title';
        $this->contents['LANG_ENTER_DESIGNATION_TITLE'] = 'Enter Designation Title';
        $this->contents['LANG_ENTER_DESIGNATION_DESCRIPTIONS'] = 'Enter Designation Description';
        $this->contents['LANG_DESIGNATION_GROUP'] = 'Designation Group';
    }
}
?>