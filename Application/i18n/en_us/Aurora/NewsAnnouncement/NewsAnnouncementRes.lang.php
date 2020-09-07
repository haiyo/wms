<?php
namespace Aurora\NewsAnnouncement;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: NewsAnnouncementRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NewsAnnouncementRes extends Resource {


    /**
    * NewsAnnouncementRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        
        $this->contents = array( );
        $this->contents['LANG_NO_NEWS_OR_ANNOUNCEMENT'] = 'There are currently no news and announcement.';
        $this->contents['LANG_NEWS_ANNOUNCEMENT'] = 'News &amp; Announcement';
        $this->contents['LANG_ADD_NEW_CONTENT'] = 'Add New Content';
        $this->contents['LANG_MANAGE'] = 'Manage';
        $this->contents['LANG_ANNOUNCEMENT'] = 'Announcement';
        $this->contents['LANG_NEWS'] = 'News';
        $this->contents['LANG_CREATE_NEW_CONTENT'] = 'Create New Content';
        $this->contents['LANG_SELECT_CONTENT_TYPE'] = 'Select Content Type';
        $this->contents['LANG_TITLE'] = 'Title';
        $this->contents['LANG_PLEASE_SELECT_CONTENT_TYPE'] = 'Please select a Content Type';
        $this->contents['LANG_PLEASE_ENTER_TITLE'] = 'Please enter title';
        $this->contents['LANG_PLEASE_ENTER_CONTENT'] = 'Please enter content';
        $this->contents['LANG_CONTENT_TYPE'] = 'Content Type';
        $this->contents['LANG_AUTHOR'] = 'Author';
        $this->contents['LANG_DATE_CREATED'] = 'Date Created';
        $this->contents['LANG_ENTER_TITLE_FOR_CONTENT'] = 'Enter title for this content';
        $this->contents['LANG_CONTENT'] = 'Content';
        $this->contents['LANG_SEARCH_TITLE_AUTHOR'] = 'Search Title or Author Name';
        $this->contents['LANG_EDIT_CONTENT'] = 'Edit Content';
        $this->contents['LANG_DELETE_CONTENT'] = 'Delete Content';
        $this->contents['LANG_CONTENT_CREATED_SUCCESSFULLY'] = 'Content has been successfully created!';
	}
}
?>