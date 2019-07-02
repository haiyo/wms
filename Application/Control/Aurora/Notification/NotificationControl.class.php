<?php
namespace Aurora\Notification;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: NotificationControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NotificationControl {


    // Properties
    private $NotificationModel;
    private $NotificationView;


    /**
     * NotificationControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->NotificationModel = new NotificationModel( );
        $this->NotificationView = new NotificationView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function markRead( ) {
        $this->NotificationModel->markRead( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getCount( ) {
        $vars['bool'] = 1;
        $vars['count'] = $this->NotificationModel->getUnreadCount( );
        echo json_encode( $vars );
        exit;
    }
}
?>