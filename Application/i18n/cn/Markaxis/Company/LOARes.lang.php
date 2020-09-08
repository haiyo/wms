<?php
namespace Markaxis\Company;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LOARes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LOARes extends Resource {


    /**
    * LOARes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        
        $this->contents = array( );
        $this->contents['LANG_LETTER_OF_APPOINTMENT'] = 'Letter Of Appointment';
        $this->contents['LANG_CREATE_NEW_LOA'] = 'Create New LOA';
        $this->contents['LANG_FOR_WHICH_DESIGNATION'] = 'For Which Designation';
        $this->contents['LANG_PLEASE_SELECT_DESIGNATION'] = 'Please select a Designation';
        $this->contents['LANG_PLEASE_ENTER_CONTENT'] = 'Please enter content.';
        $this->contents['LANG_FOR_DESIGNATION'] = 'For Designation(s)';
        $this->contents['LANG_LAST_UPDATED_BY'] = 'Last Updated By';
        $this->contents['LANG_LAST_UPDATED'] = 'Last Updated';
        $this->contents['LANG_CONTENT'] = 'Content';
        $this->contents['LANG_SAVE_CHANGES'] = 'Save changes';
        $this->contents['LANG_LOA_SUCCESSFULLY_CREATED'] = 'Letter Of Appointment has been successfully created!';
        $this->contents['LANG_EDIT_LOA'] = 'Edit LOA';
        $this->contents['LANG_CREATE_NEW_LOA'] = 'Create New LOA';
        $this->contents['LANG_DELETE_LOA'] = 'Delete LOA';
	}
}
?>