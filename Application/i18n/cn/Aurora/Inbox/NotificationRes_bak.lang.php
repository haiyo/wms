<?php
namespace Aurora;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: NotificationRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NotificationRes extends Resource {


    /**
    * NotificationRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_NOTIFICATION_INBOX'] = 'Notification Inbox';
        $this->contents['LANG_NOTIFICATIONS'] = 'Notifications';
	}
}
?>