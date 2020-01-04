<?php
namespace Aurora\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: NewsAnnouncementRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NewsAnnouncementRes extends Resource {


    /**
    * OnOffRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_ANNOUNCEMENT']  = 'Announcement';
        $this->contents['LANG_NEWS'] = 'News';
	}
}
?>