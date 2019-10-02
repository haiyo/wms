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
	}
}
?>