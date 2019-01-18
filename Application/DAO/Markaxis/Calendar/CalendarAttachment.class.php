<?php
namespace Markaxis;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CalendarAttachment.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarAttachment extends \DAO {
    

    // Properties

    
    /**
    * CalendarAttachment Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct();
	}


    /**
    * Return total count by Event
    * @return int
    */
    public function countByEventID( $eventID ) {
        $sql = $this->DB->select( 'SELECT COUNT(attID) FROM markaxis_event_attachment
                                   WHERE eventID = "' . (int)$eventID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
    * Retrieve a single attachment
    * @return mixed
    */
    public function getByID( $attID ) {
        $sql = $this->DB->select( 'SELECT e.userID, e.privacy, ea.*
                                   FROM markaxis_event e, markaxis_event_attachment ea
                                   WHERE e.eventID = ea.eventID AND
                                         ea.attID = "' . (int)$attID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
    * Retrieve all attachments
    * @return mixed
    */
    public function getByEventID( $eventID ) {
        $list = array( );
        $sql = $this->DB->select( 'SELECT * FROM markaxis_event_attachment
                                   WHERE eventID = "' . (int)$eventID . '"',
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