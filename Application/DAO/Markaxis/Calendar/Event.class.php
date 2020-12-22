<?php
namespace Markaxis\Calendar;
use \Library\Helper\Markaxis\RecurHelper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: Event.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Event extends \DAO {


    // Properties


    /**
    * Retrieve Events Between a Start and End Timestamp
    * @return mixed
    */
    public function getEventsBetweenByUserID( $start, $end, $userID ) {
        $sql = $this->DB->select( 'SELECT e.*, e.eID AS id, e.start AS startDateTime, e.label AS classNames,
                                               e.end AS endDateTime 
                                   FROM event e
                                   LEFT JOIN user u ON ( u.userID = e.userID )
                                   WHERE u.userID = "' . (int)$userID . '" AND
                                         u.suspended = "0" AND
                                         e.start <= "' . addslashes( $end ) . '" AND
                                         e.end >= "' . addslashes( $start ) . '" AND
                                         e.recurType IS NULL',
                                   __FILE__, __LINE__ );

        $events = array( );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $row['allDay'] = $row['allDay'] ? true : false;
                $row['classNames'] = 'myEvents ' . $row['label'];
                $events[] = $row;
            }
        }
        return $events;
    }


    /**
     * Retrieve Events Between a Start and End Timestamp
     * @return mixed
     */
    public function getEventsBetweenByColleague( $start, $end, $userID ) {
        $sql = $this->DB->select( 'SELECT CONCAT( u.fname, " ", u.lname ) AS name,
                                          e.*, e.eID AS id, e.start AS startDateTime, e.label AS classNames,
                                          e.end AS endDateTime 
                                   FROM event e
                                   LEFT JOIN user u ON ( u.userID = e.userID )
                                   WHERE u.userID <> "' . (int)$userID . '" AND 
                                         u.suspended = "0" AND
                                         e.public = "1" AND
                                         e.start <= "' . addslashes( $end ) . '" AND
                                         e.end >= "' . addslashes( $start ) . '" AND
                                         e.recurType IS NULL',
                                         __FILE__, __LINE__ );

        $events = array( );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $row['allDay'] = $row['allDay'] ? true : false;
                $row['classNames'] = 'colleagues ';
                $events[] = $row;
            }
        }
        return $events;
    }


    /**
    * Retrieve Events Between a Start and End Timestamp
    * @return mixed
    */
    public function getRecurs( $userID, $type ) {
        $events = array( );
        $sql = $this->DB->select( 'SELECT e.*, e.eID AS id, e.start AS startDateTime, e.label AS classNames,
                                               e.end AS endDateTime
                                   FROM event e
                                   LEFT JOIN user u ON ( u.userID = e.userID )
                                   WHERE u.userID = "' . (int)$userID . '" AND
                                         u.suspended = "0" AND
                                         e.recurType = "' . addslashes( $type ) . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            $type = RecurHelper::getL10nList( );

            while( $row = $this->DB->fetch( $sql ) ) {
                $row['allDay']    = $row['allDay'] ? true : false;
                $row['recurText'] = $type[$row['recurType']];
                $row['classNames'] = 'myEvents ' . $row['label'];
                $events[] = $row;
            }
        }
        return $events;
    }


    /**
     * Retrieve Events Between a Start and End Timestamp
     * @return mixed
     */
    public function getRecursByColleague( $userID, $type ) {
        $sql = $this->DB->select( 'SELECT e.*, e.eID AS id, e.start AS startDateTime, e.label AS classNames,
                                               e.end AS endDateTime 
                                   FROM event e
                                   LEFT JOIN user u ON ( u.userID = e.userID )
                                   WHERE u.userID <> "' . (int)$userID . '" AND 
                                         u.suspended = "0" AND
                                         e.public = "1" AND
                                         e.recurType = "' . addslashes( $type ) . '"',
                                   __FILE__, __LINE__ );

        $events = array( );

        if( $this->DB->numrows( $sql ) > 0 ) {
            $type = RecurHelper::getL10nList( );
            while( $row = $this->DB->fetch( $sql ) ) {
                $row['allDay']    = $row['allDay'] ? true : false;
                $row['recurText'] = $type[$row['recurType']];
                $row['classNames'] = 'colleagues';
                $events[] = $row;
            }
        }
        return $events;
    }


    /**
    * Retrieve a single event
    * @return mixed
    */
    public function formatEvent( $sql, $recur=false ) {
        $events = array( );
        
        return $events;
    }


    /**
    * Retrieve a single event
    * @return mixed
    */
    public function getEventByID( $eventID, $userID=0 ) {
        $sql = $this->DB->select( 'SELECT e.*, e.title AS eTitle, e.address AS eAddress,
                                          e.label AS className,
                                          re.recurID, re.recurType, re.repeatTimes,
                                          re.endRecur, re.occurrences, re.untilDate,
                                          u.*, l.label AS labelType,
                                   GROUP_CONCAT(r.title) AS roleTitle
                                   FROM markaxis_event e
                                   LEFT OUTER JOIN markaxis_event_label l ON(e.label = l.color)
                                   LEFT OUTER JOIN `user` u ON(e.userID = u.userID)
                                   LEFT OUTER JOIN user_role ur ON(u.userID = ur.userID)
                                   LEFT OUTER JOIN role r ON(ur.roleID = r.roleID)
                                   LEFT OUTER JOIN markaxis_event_recur re ON(e.eventID = re.eventID)
                                   WHERE e.eventID = "' . (int)$eventID . '"
                                         GROUP BY e.eventID',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
    * Retrieve Table List
    * @return mixed
    
    public function getTableList( ) {
        $list = array( );
        $sql = $this->DB->select( 'SELECT * FROM markaxis_event_from',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['tableName']] = $row['title'];
            }
        }
        return $list;
    }*/
}
?>