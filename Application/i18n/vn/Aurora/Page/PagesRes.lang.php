<?php
namespace Aurora\Page;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PagesRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PagesRes extends Resource {


    /**
    * PagesRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        
        $this->contents = array( );
        $this->contents['LANG_ADD_PAGE_TITLE'] = 'New Workspace';
        $this->contents['LANG_EDIT_PAGE_TITLE'] = 'Edit Workspace';
        $this->contents['LANG_SAVE_PAGE_TITLE'] = 'Save Workspace';
        $this->contents['LANG_CREATE_PAGE'] = 'Create Workspace';
        $this->contents['LANG_DELETE_PAGE'] = 'Delete Workspace';
        $this->contents['LANG_ENTER_PAGE_TITLE'] = 'Enter Workspace Title';
        $this->contents['LANG_CHOOSE_LAYOUT'] = 'Choose a Layout';
        $this->contents['LANG_UNIVERSAL_PAGE'] = 'This workspace is universal and non-removable. Everyone can view this page but only the Administrator is able to change the title and layout.';
        $this->contents['LANG_PLS_ENTER_PAGE_TITLE'] = 'Please enter a workspace title.';
        $this->contents['LANG_CONFIRM_DELETE'] = 'Are you sure you want to delete this workspace? All droplets in this page will be remove and data will not be retrievable.';
        $this->contents['LANG_WHO_CAN_VIEW'] = 'Who Can View?';
	}
}
?>