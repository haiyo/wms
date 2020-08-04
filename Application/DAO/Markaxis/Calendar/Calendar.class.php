<?php
namespace Markaxis\Calendar;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: Calendar.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Calendar extends \DAO {


    // Properties


    /**
    * Retrieve Calendar Info
    * @return mixed
    */
    public function getByCalID( $calID ) {
        $sql = $this->DB->select( 'SELECT * FROM markaxis_calendar
                                   WHERE calID = "' . (int)$calID . '"',
                                   __FILE__, __LINE__ );
        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
    * Retrieve Calendar Info
    * @return mixed
    */
    public function getCalByDefault( $userID ) {
        $sql = $this->DB->select( 'SELECT * FROM markaxis_calendar
                                   WHERE userID = "' . (int)$userID . '" AND
                                         isDefault = "1"',
                                   __FILE__, __LINE__ );
        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
    * Get all eventIDs by calID
    * @return mixed[]
    */
    public function getEventIDByCalID( $calID ) {
        $events = array( );
        $sql = $this->DB->select( 'SELECT eventID FROM markaxis_event
                                   WHERE calID = "' . (int)$calID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $events[] = $row;
            }
        }
        return $events;
    }


    /**
    * Retrieve Events Between a Start and End Timestamp
    * @return mixed
    */
    public function getEventsBetween( $calID, $start, $end ) {
        $events = array( );
        $sql = $this->DB->select( 'SELECT DISTINCT e.*, e.title AS eTitle, e.eventID AS id,
                                          u.userID, u.fname, u.lname,
                                          ua.hashName, ua.hashDir,
                                          l.label AS labelType, e.label AS className,
                                          r.title AS roleTitle
                                   FROM markaxis_event e, markaxis_event_label l, user u
                                   LEFT OUTER JOIN user_role ur ON(u.userID = ur.userID)
                                   LEFT JOIN user_avatar ua ON(ua.userID = u.userID)
                                   LEFT OUTER JOIN role r ON(ur.roleID = r.roleID)
                                   WHERE e.recur = "0" AND
                                         e.userID = u.userID AND
                                         u.status = "active" AND
                                         e.label = l.color AND
                                         e.calID = "' . (int)$calID . '" AND
                                         e.start <= "' . addslashes( $end ) . '" AND
                                         e.end >= "' . addslashes( $start ) . '"',
                                   __FILE__, __LINE__ );
        
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $row['allDay'] = $row['allDay'] ? true : false;
                $events[] = $row;
            }
        }
        return $events;
    }


            /*   GROUP BY e.eventID | /Users/andylam/Sites/serp/Application/DAO/Markaxis/Calendar/Calendar.class.php | 101
[15/Aug/2018 16:41:35] Expression #19 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'serp.re.recurID' which is not functionally 
//dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by on query: SELECT e.*, e.title AS eTitle, e.eventID AS id, re.*,
                                          u.userID, u.fname, u.lname, ua.hashName, ua.hashDir,
                                          l.label AS labelType, e.label AS className,
                                          GROUP_CONCAT(r.title) AS roleTitle
                                   FROM markaxis_event e, markaxis_event_label l,
                                        markaxis_event_recur re, user u
                                   LEFT OUTER JOIN user_role ur ON(u.userID = ur.userID)
                                   LEFT JOIN user_avatar ua ON(ua.userID = u.userID)
                                   LEFT OUTER JOIN role r ON(ur.roleID = r.roleID)
                                   WHERE e.recur = "1" AND
                                         e.eventID = re.eventID AND
                                         e.userID = u.userID AND
                                         u.status = "active" AND
                                         e.label = l.color AND
                                         e.calID = "41"
                                   GROUP BY e.eventID | /Users/andylam/Sites/serp/Applica*/
    /**
    * Retrieve Events Between a Start and End Timestamp
    * @return mixed
    */
    public function getRecurs( $calID ) {
        $events = array( );
        $sql = $this->DB->select( 'SELECT DISTINCT e.*, e.title AS eTitle, e.eventID AS id, re.*,
                                          u.userID, u.fname, u.lname, ua.hashName, ua.hashDir,
                                          l.label AS labelType, e.label AS className,
                                          r.title AS roleTitle
                                   FROM markaxis_event e, markaxis_event_label l,
                                        markaxis_event_recur re, user u
                                   LEFT OUTER JOIN user_role ur ON(u.userID = ur.userID)
                                   LEFT JOIN user_avatar ua ON(ua.userID = u.userID)
                                   LEFT OUTER JOIN role r ON(ur.roleID = r.roleID)
                                   WHERE e.recur = "1" AND
                                         e.eventID = re.eventID AND
                                         e.userID = u.userID AND
                                         u.status = "active" AND
                                         e.label = l.color AND
                                         e.calID = "' . (int)$calID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            $type = RecurHelper::getL10nList( );
            while( $row = $this->DB->fetch( $sql ) ) {
                $row['allDay']    = $row['allDay'] ? true : false;
                $row['recurText'] = $type[$row['recurType']];
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