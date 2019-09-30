<?php
namespace Aurora\NewsAnnouncement;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: NewsAnnouncement.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NewsAnnouncement extends \DAO {


    // Properties


    /**
     * Return total count of messages
     * @return int
     */
    public function getUnreadCount( $userID ) {
        $sql = $this->DB->select( 'SELECT COUNT(nuID) FROM notification_user nu
                                   WHERE nu.toUserID = "' . (int)$userID . '" AND
                                         nu.hasRead = "0"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all by userID
     * @return mixed
     */
    public function getList( ) {
        $list = array( );
        $sql = $this->DB->select( 'SELECT *, DATE_FORMAT(na.created, "%D %b %Y") AS created 
                                   FROM news_annoucement na
                                   LEFT JOIN user u ON( u.userID = na.userID )
                                   ORDER BY na.created DESC ' . $this->limit,
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