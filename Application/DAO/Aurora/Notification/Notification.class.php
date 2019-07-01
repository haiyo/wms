<?php
namespace Aurora\Notification;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Notification.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Notification extends \DAO {


    // Properties


    /**
     * Return total count of messages
     * @return int
     */
    public function getUnreadCount( $userID ) {
        $sql = $this->DB->select( 'SELECT COUNT(nuID) FROM notification_user nu
                                   WHERE nu.toUserID = "' . (int)$userID . '" AND
                                         nu.isRead = "0"',
            __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all by userID
     * @return mixed
     */
    public function getByUserID( $userID ) {
        $list = array( );
        $sql = $this->DB->select( 'SELECT *, nu.created AS nuCreated FROM notification_user nu
                                          LEFT JOIN notification n ON(n.nID = nu.nID)
                                          LEFT JOIN user u ON(u.userID = nu.userID)
                                          LEFT OUTER JOIN user_image ui ON(ui.userID = nu.userID)
                                   WHERE nu.toUserID = "' . (int)$userID . '"
                                          ORDER BY nuCreated DESC ' . $this->limit,
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }
}
?>