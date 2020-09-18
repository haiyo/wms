<?php
namespace Aurora\Page;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PageRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PageRes extends Resource {


    /**
    * PageRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        
        $this->contents = array( );
        $this->contents['LANG_HOME'] = 'Home';
        $this->contents['LANG_FOUND_ISSUE'] = 'Found An Issue?';
        $this->contents['LANG_TELL_US_WHATS_WRONG'] = 'Tell Us What Went Wrong';
        $this->contents['LANG_SUBJECT'] = 'Subject';
        $this->contents['LANG_ENTER_SUBJECT'] = 'Subject of the issue';
        $this->contents['LANG_DESCRIPTION'] = 'Description';
        $this->contents['LANG_ENTER_DESCRIPTION'] = 'Descript what went wrong and the steps to reproduce the issue.';
        $this->contents['LANG_UPLOAD_SCREENSHOT'] = 'Upload Screenshot';
        $this->contents['LANG_EDIT_PROFILE'] = 'Edit Profile';
        $this->contents['LANG_LOGOUT'] = 'Logout';
	}
}
?>