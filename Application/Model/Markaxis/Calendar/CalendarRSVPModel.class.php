<?php
namespace Markaxis\Calendar;
use Aurora\NotificationModel;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CalendarRSVPModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarRSVPModel extends \Model {


    // Properties
    protected $userInfo;


    /**
    * CalendarRSVPModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $Authenticator  = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $this->userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );
	}


    /**
    * Get By eventID
    * @return mixed[]
    */
    public function getByEventID( $eventID ) {
        $CalendarRSVP = new CalendarRSVP( );
        return $CalendarRSVP->getByEventID( $eventID );
    }


    /**
    * Set new RSVP info on POST
    * @return bool
    */
    public function validate( ) {
        $CalendarModel = CalendarModel::getInstance( );
        $data = $CalendarModel->getInfo('data');
        $sizeOf = sizeof( $data );

        for( $i=0; $i<$sizeOf; $i++ ) {
            preg_match( '/(.*)=(.*)/', $data[$i], $match );

            switch( $match[1] ) {
                case 'rsvpID' :
                if( $match[2] != '' ) {
                    $this->info['rsvpID'] = explode( ',', urldecode( $match[2] ) );

                    // Is this RSVP event?
                    if( sizeof( $this->info['rsvpID'] ) > 0 ) {
                        $this->info['eventID'] = $CalendarModel->getInfo('eventID');

                        // Automatically add in creator's userID first.
                        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
                        $UserModel = $Authenticator->getUserModel( );
                        $this->info['invite'] = array( );
                        $this->info['invite'][$this->userInfo['userID']] = 1;

                        foreach( $this->info['rsvpID'] as $userID ) {
                            if( $UserModel->getFieldByUserID( $userID, 'u.userID' ) ) {
                                $this->info['invite'][$userID] = 0;
                            }
                        }
                        return true;
                    }
                }
                return false;
                break;
            }
        }
        return false;
    }


    /**
    * Save RSVP Info
    * @return mixed
    */
    public function save( ) {
        $CalendarRSVP = new CalendarRSVP( );
        $rsvpList = $CalendarRSVP->getByEventID( $this->info['eventID'] );

        $rsvp = 0;
        $invitees = array( );

        foreach( $this->info['invite'] as $userID => $attending ) {
            if( isset( $rsvpList[$userID] ) ) {
                // Restore back the already exist list if found
                $info = array( );
                $info['eventID']   = $this->info['eventID'];
                $info['userID']    = $userID;
                $info['attending'] = $rsvpList[$userID]['attending'];
                $invitees[] = $info;
                continue;
            }
            $info = array( );
            $info['eventID']   = $this->info['eventID'];
            $info['userID']    = $userID;
            $info['attending'] = $attending;
            $invitees[] = $info;
        }

        if( sizeof( $rsvpList ) > 0 ) {
            $CalendarRSVP->delete( 'markaxis_event_rsvp', 'WHERE eventID = "' . (int)$this->info['eventID'] . '"' );
        }
        if( sizeof( $invitees ) > 0 ) {
            $NotificationModel = new NotificationModel( );

            $CalendarModel = CalendarModel::getInstance( );
            $startDate = $CalendarModel->getInfo('start');
            $endDate   = $CalendarModel->getInfo('end');
            $allDay    = $CalendarModel->getInfo('allDay') ? true : false;

            $popup = array( );
            $popup['modalID'] = 'getEvent' . $this->info['eventID'];
            $popup['width']   = 700;
            $popup['height']  = 600;
            $nID = $NotificationModel->addNew( $this->info['eventID'],
                                               'admin/calendar/getEvent/' . $this->info['eventID'] . '/' .
                                               $startDate . '/' . $endDate . '/' . $allDay,
                                               serialize( $popup ),
                                               'Markaxis/Calendar',
                                               'Markaxis',
                                               'CalendarRSVPControl' );
            $rsvp = 1;
            foreach( $invitees as $row ) {
                $CalendarRSVP->insert( 'markaxis_event_rsvp', $row );

                if( $row['userID'] != $this->userInfo['userID'] ) {
                    $NotificationModel->notify( $nID, $row['userID'] );
                }
            }
        }
        $info = array( );
        $info['rsvp'] = $rsvp;
        $CalendarRSVP->update( 'markaxis_event', $info, 'WHERE eventID = "' . (int)$this->info['eventID'] . '"' );
        return true;
    }


    /**
    * Update RSVP
    * @return mixed
    */
    public function update( $eventID, $type ) {
        $valid = array( 1, 0, '-1', 2 );

        if( in_array( $type, $valid ) ) {
            $CalendarRSVP = new CalendarRSVP( );
            $info = array( );
            $info['attending'] = $type;
            $CalendarRSVP->update( 'markaxis_event_rsvp', $info, 'WHERE eventID = "' . (int)$eventID . '" AND
                                                                        userID = "' . (int)$this->userInfo['userID'] . '"' );
            return array( 'userID' => $this->userInfo['userID'] );
        }
    }


    /**
    * Set Feed Property Info
    * @return bool
    */
    public function setInfo( $info ) {
        $CalendarModel = CalendarModel::getInstance( );

        if( isset( $info['eventID'] ) && $CalendarModel->loadEvent( $info['eventID'] ) ) {
            $eventInfo = $CalendarModel->getInfo( );

            if( $eventInfo['privacy'] ) {
                $CalendarRSVP = new CalendarRSVP( );

                if( !$CalendarRSVP->isInvited( $info['eventID'], $this->userInfo['userID'] ) ) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }
}
?>