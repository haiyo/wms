<?php
namespace Markaxis;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: CalendarRSVP.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarRSVP extends \DAO {


    // Properties


    /**
    * CalendarRSVP Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct();
	}


    /**
    * Retrieve all rsvp
    * @return mixed
    */
    public function getByEventID( $eventID ) {
        $list = array( );
        $sql = $this->DB->select( 'SELECT * FROM markaxis_event_rsvp e, user u
                                   LEFT JOIN user_avatar ua ON(ua.userID = u.userID)
                                   WHERE e.eventID = "' . (int)$eventID . '" AND
                                         e.userID  = u.userID',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['userID']] = $row;
            }
        }
        return $list;
    }


    /**
    * Retrieve all rsvp
    * @return mixed
    */
    public function isInvited( $eventID, $userID ) {
        $sql = $this->DB->select( 'SELECT COUNT(rsvpID) FROM markaxis_event_rsvp e
                                   WHERE e.eventID = "' . (int)$eventID . '" AND
                                         e.userID  = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
    * Retrieve all attachments
    * @return mixed

    public function getUpdateByEventID( $eventID ) {
        $list = array( );
        $sql = $this->DB->select( 'SELECT * FROM markaxis_event_rsvp e
                                   WHERE e.eventID = "' . (int)$eventID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['userID']] = $row;
            }
        }
        return $list;
    }*/
}
?>