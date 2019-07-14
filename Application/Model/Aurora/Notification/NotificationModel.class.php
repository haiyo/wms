<?php
namespace Aurora\Notification;
use \Aurora\User\UserModel;
use \Library\Interfaces\IObservable, \Library\Helper\HTMLHelper;

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
    public function getByUserID( $curPage=0, $pageLimit=10 ) {
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
                                            array( 'hasRead' => 1 ),
                                           'WHERE toUserID = "' . (int)$this->userInfo['userID'] . '"' );
    }


    /**
     * Add new notification
     * @return int
     */
    public function notify( IObservable $object ) {
        $this->info = $object->getInfo( );

        if( isset( $this->info['userID'] ) && isset( $this->info['toUserID'] ) &&
            isset( $this->info['message'] ) && isset( $this->info['url'] ) ) {
            if( isset( $this->info['userID'] ) || !$this->info['ceated'] ) {
                $this->info['created'] = date( 'Y-m-d H:i:s' );
            }
            $this->create( );
        }
    }


    /**
     * Add new notification
     * @return int
     */
    public function create( ) {
        $info = array( );
        $info['message'] = $this->info['message'];
        $info['url'] = $this->info['url'];
        $info['created'] = $this->info['created'];

        $HTMLHelper = new HTMLHelper( );
        $vars = array( );
        $vars['TPLVAR_FNAME'] = $this->userInfo['fname'];
        $vars['TPLVAR_LNAME'] = $this->userInfo['lname'];
        $info['message'] = $HTMLHelper->parseTemplate( $this->info['message'], $vars );
        $nID = $this->Notification->insert( 'notification', $info );

        if( is_array( $this->info['toUserID'] ) ) {
            foreach( $this->info['toUserID'] as $toUserID ) {
                $info = array( );
                $info['nID'] = (int)$nID;
                $info['userID'] = (int)$this->info['userID'];
                $info['toUserID'] = (int)$toUserID;
                $this->Notification->insert( 'notification_user', $info );
            }
        }
    }
}
?>