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
	}
}
?>