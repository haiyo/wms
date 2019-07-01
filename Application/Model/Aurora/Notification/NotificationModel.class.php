<?php
namespace Aurora\Notification;
use \Aurora\User\UserModel;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, July 4th, 2012
 * @version $Id: NotificationModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NotificationModel extends \Model {


    // Properties
    protected $Notification;
    protected $userInfo;


    /**
     * NotificationModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->Notification = new Notification( );
        $this->userInfo = UserModel::getInstance( )->getInfo( );
    }


    /**
     * Return list by userID
     * @return mixed
     */
    public function getByUserID( $curPage=1, $pageLimit=10 ) {
        $this->Notification->setLimit( $curPage, $pageLimit );
        return $this->Notification->getByUserID( $this->userInfo['userID'] );
    }


    /**
     * Return number of unread notices
     * @return int
     */
    public function getUnreadCount( ) {
        return $this->Notification->getUnreadCount( $this->userInfo['userID'] );
    }


    /**
     * Mark all as read
     * @return int
     */
    public function markRead( ) {
        return $this->Notification->update('notification_user',
                                            array( 'isRead' => 1 ),
                                           'WHERE toUserID = "' . (int)$this->userInfo['userID'] . '"' );
    }


    /**
     * Add new notification
     * @return int
     */
    public function notify( $userID, $toUserID, $url, $created=NULL ) {
        if( !$created ) {
            $info['created'] = date( 'Y-m-d H:i:s' );
        }
        $this->create( $userID, $toUserID, $url, $created );
    }


    /**
     * Add new notification
     * @return int
     */
    public function create( $userID, $toUserID, $url, $created ) {
        $info = array( );
        $info['userID'] = (int)$userID;
        $info['toUserID'] = (int)$toUserID;
        $info['url'] = $url;
        $info['created'] = $created;
        return $this->Notification->insert( 'notification', $info );
    }
}
?>