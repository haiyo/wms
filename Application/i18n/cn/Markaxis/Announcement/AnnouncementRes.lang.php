<?php
namespace Markaxis\Announcement;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: AnnouncementRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AnnouncementRes extends Resource {


    // Properties


    /**
     * AnnouncementRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_NEWS_ANNOUNCEMENT'] = 'News &amp; Announcement';
    }
}
?>