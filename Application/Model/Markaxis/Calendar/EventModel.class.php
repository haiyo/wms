<?php
namespace Markaxis\Calendar;
use \Aurora\User\UserModel;
use \Library\Util\Markaxis\Calendar\DayRecur;
use \Library\Util\Markaxis\Calendar\WeekRecur;
use \Library\Util\Markaxis\Calendar\BiWeeklyRecur;
use \Library\Util\Markaxis\Calendar\WeekDayRecur;
use \Library\Util\Markaxis\Calendar\NDayRecur;
use \Library\Util\Markaxis\Calendar\MonthRecur;
use \Library\Util\Markaxis\Calendar\YearRecur;
use \Library\Util\Markaxis\Calendar\Event AS LibEvent;
use \Library\Helper\Markaxis\LabelHelper;
use \Library\Helper\Markaxis\RecurHelper, \Library\Helper\Markaxis\ReminderHelper;
use \Library\Validator\Validator, \Library\Util\Date;
use \DateTime;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: EventModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EventModel extends \Model {


    //properties
    protected $Event;


    /**
    * EventModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Calendar/EventRes');

        $this->Event = new Event( );

        $this->info['eID']       = 0;
        $this->info['title']     = '';
        $this->info['descript']  = '';
        $this->info['label']     = 'blue';
        $this->info['public']    = 0;
        $this->info['allDay']    = 0;
        $this->info['start']     = '';
        $this->info['end']       = '';
        $this->info['reminder']  = 0;
	}


    /**
     * Retrieve Events Between a Start and End Timestamp
     * @return mixed
     */
    public function getEvents( $info ) {
        $eventList = array( );

        if( isset( $info['start'] ) && isset( $info['end'] ) ) {
            $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
            $userInfo  = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

            $startDate = Date::parseDateTime( $info['start'] );
            $endDate = Date::parseDateTime( $info['end'] );

            if( $info['user'] == 'owner' ) {
                $eventList = $this->Event->getEventsBetweenByUserID( $startDate, $endDate, $userInfo['userID'] );
            }
            else {
                $eventList = $this->Event->getEventsBetweenByColleague( $startDate, $endDate, $userInfo['userID'] );

                foreach( $eventList as $key => $event ) {
                    $eventList[$key]['title'] = $event['name'] . ' - ' . $event['title'];
                }
            }
        }
        return $eventList;
    }


    /**
     * Retrieve recurring events
     * @return mixed
     */
    public function getRecurs( $info ) {
        $effective = array( );

        if( isset( $info['user'] ) && isset( $info['type'] ) && isset( $info['start'] ) && isset( $info['end'] ) ) {
            $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
            $userInfo  = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

            if( $info['user'] == 'owner' ) {
                $eventInfo = $this->Event->getRecurs( $userInfo['userID'], $info['type'] );
            }
            else {
                $eventInfo = $this->Event->getRecursByColleague( $userInfo['userID'], $info['type'] );
            }
            $size = sizeof( $eventInfo );

            for( $i=0; $i<$size; $i++ ) {
                if( $eventInfo[$i]['recurType'] === 'day' ) {
                    $DayRecur = new DayRecur( $info['start'], $info['end'] );
                    $DayRecur->setEvent( new LibEvent( $eventInfo[$i] ) );
                    $effective = array_merge( $DayRecur->getEvents( ), $effective );
                }
                else if( $eventInfo[$i]['recurType'] === 'week' ) {
                    $WeekRecur = new WeekRecur( $info['start'], $info['end'] );
                    $WeekRecur->setEvent( new LibEvent( $eventInfo[$i] ) );
                    $effective = array_merge( $WeekRecur->getEvents( ), $effective );
                }
                else if( $eventInfo[$i]['recurType'] === 'biweekly' ) {
                    $BiWeeklyRecur = new BiWeeklyRecur( $info['start'], $info['end'] );

                    $LibEvent = new LibEvent( $eventInfo[$i] );
                    $LibEvent->setInfo( 'recurType', 'week' );
                    $LibEvent->setInfo( 'repeatTimes', 2 );

                    $BiWeeklyRecur->setEvent( $LibEvent );
                    $effective = array_merge( $BiWeeklyRecur->getEvents( ), $effective );
                }
                else if( $eventInfo[$i]['recurType'] === 'weekday' ) {
                    $WeekDayRecur = new WeekDayRecur( $info['start'], $info['end'] );
                    $WeekDayRecur->setEvent( new LibEvent( $eventInfo[$i] ) );
                    $effective = array_merge( $WeekDayRecur->getEvents( ), $effective );
                }
                else if( $eventInfo[$i]['recurType'] === 'monWedFri' ) {
                    $NDayRecur = new NDayRecur( $info['start'], $info['end'] );
                    $NDayRecur->setNDay( array(1,3,5) );
                    $NDayRecur->setEvent( new LibEvent( $eventInfo[$i] ) );
                    $effective = array_merge( $NDayRecur->getEvents( ), $effective );
                }
                else if( $eventInfo[$i]['recurType'] === 'tueThur' ) {
                    $NDayRecur = new NDayRecur( $info['start'], $info['end'] );
                    $NDayRecur->setNDay( array(2,4) );
                    $NDayRecur->setEvent( new LibEvent( $eventInfo[$i] ) );
                    $effective = array_merge( $NDayRecur->getEvents( ), $effective );
                }
                else if( $eventInfo[$i]['recurType'] === 'month' ) {
                    $MonthRecur = new MonthRecur( $info['start'], $info['end'] );
                    $MonthRecur->setEvent( new LibEvent( $eventInfo[$i] ) );
                    $effective = array_merge( $MonthRecur->getEvents( ), $effective );
                }
                else if( $eventInfo[$i]['recurType'] === 'year' ) {
                    $YearRecur = new YearRecur( $info['start'], $info['end'] );
                    $YearRecur->setEvent( new LibEvent( $eventInfo[$i] ) );
                    $effective = array_merge( $YearRecur->getEvents( ), $effective );
                }
            }
        }
        return $effective;
    }


    /**
    * Set new event info on date selection (prepare for form)
    * @return void
    */
    public function setNewEventInfo( $info ) {
        // NOTE: We allow info to be empty during scenerio when user updating labels.
        // The form original value will be populated on the client side (javascript).
        if( isset( $info[1] ) ) $this->info['calID']  = $info[1];
        if( isset( $info[2] ) ) $this->info['start']  = $info[2];
        if( isset( $info[3] ) ) $this->info['end']    = $info[3];
        if( isset( $info[4] ) ) $this->info['allDay'] = $info[4];
    }


    /**
     * Set Pay Item Info
     * @return bool
     */
    public function isValid( $data ) {
        $this->info['eID'] = (int)$data['eID'];
        $this->info['title'] = Validator::stripTrim( $data['title'] );
        $this->info['descript'] = Validator::stripTrim( $data['descript'] );
        $this->info['recurType'] = Validator::stripTrim( $data['recurType'] );
        $this->info['reminder'] = Validator::stripTrim( $data['reminder'] );
        $this->info['label'] = Validator::stripTrim( $data['label'] );

        $this->info['allDay']  = ( isset( $data['allDay']  ) && $data['allDay']  ) ? 1 : 0;
        $this->info['public'] = ( isset( $data['public'] ) && $data['public'] ) ? 1 : 0;

        if( !$this->info['title'] ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_PROVIDE_ALL_REQUIRED') );
            return false;
        }

        $startDate = DateTime::createFromFormat('d M Y', $data['startDate'] )->format('Y-m-d');
        $endDate   = DateTime::createFromFormat('d M Y', $data['endDate'] )->format('Y-m-d');

        if( !$startDate || !$endDate ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_PROVIDE_ALL_REQUIRED') );
            return false;
        }

        $startTime = isset( $data['startTime'] ) ? $data['startTime'] : '';
        $endTime   = isset( $data['endTime'] ) ? $data['endTime'] : '';
        $unixStart = strtotime($startDate . ' ' . $startTime );
        $unixEnd = strtotime($endDate . ' ' . $endTime );

        $this->info['start'] = date('Y-m-d H:i', $unixStart);
        $this->info['end'] = date('Y-m-d H:i', $unixEnd);

        if( $this->info['recurType'] && !in_array( $this->info['recurType'], RecurHelper::getList( ) ) ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_PROVIDE_ALL_REQUIRED') );
            return false;
        }
        else if( $this->info['recurType'] == '' ) {
            $this->info['recurType'] = NULL;
        }

        if( $this->info['reminder'] && !in_array( $this->info['reminder'], ReminderHelper::getList( ) ) ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_PROVIDE_ALL_REQUIRED') );
            return false;
        }
        else if( $this->info['reminder'] == '' ) {
            $this->info['reminder'] = NULL;
        }

        if( $this->info['label'] && !in_array( $this->info['label'], LabelHelper::getList( ) ) ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_PROVIDE_ALL_REQUIRED') );
            return false;
        }

        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo  = $Authenticator->getUserModel( )->getInfo( 'userInfo' );
        $this->info['userID'] = $userInfo['userID'];
        $this->info['created'] = date( 'Y-m-d H:i:s' );
        return true;
    }


    /**
    * Retrieve Events Between a Start and End Timestamp
    * @return mixed
    
    public function getAllEvents( $info ) {
        $Calendar = new Calendar( );
        if( isset( $info['allDay'] ) && $info['allDay'] == 'true' ) {
            $info['end'] = strtotime( date( 'Y-m-d 23:59:59', $info['end'] ) );
        }
        return $Calendar->getAllEvents( $info['dropletID'], $this->userInfo['userID'],
                                        date( 'Y-m-d H:i:s', $info['start'] ),
                                        date( 'Y-m-d H:i:s', $info['end'] ) );
    }*/


    /**
    * Save Event
    * @return mixed
    */
    public function save( ) {
        if( $this->info['eID'] == 0 ) {
            $this->info['eID']  = $this->Event->insert( 'event', $this->info );
        }
        else {
            // and userID
            $this->Event->update('event', $this->info,
                                'WHERE eID = "' . (int)$this->info['eID'] . '" AND
                                              userID = "' . (int)$this->info['userID'] . '"' );
        }
        return true;
    }


    /**
    * Update an event on user drag
    * @return bool
    */
    public function updateEventDropDrag( $post ) {
        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo  = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        if( isset( $post['eID'] ) ) {
            $info = array( );
            $info['start'] = $post['start'];
            $info['end']   = $post['end'] != '' ? $post['end'] : '0000-00-00 00:00:00';

            if( isset( $post['allDay'] ) ) {
                $info['allDay'] = (int)$post['allDay'];
            }

            $this->Event->update('event', $info,
                                'WHERE eID = "' . (int)$post['eID'] . '" AND
                                              userID = "' . (int)$userInfo['userID'] . '"' );
            return true;
        }
    }


    /**
     * Delete an event
     * @return bool
     */
    public function deleteEvent( $post ) {
        if( isset( $post['eID'] ) ) {
            $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
            $userInfo  = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

            $this->Event->delete( 'event', 'WHERE eID = "' . (int)$post['eID'] . '" AND
                                                                userID = "' . (int)$userInfo['userID'] . '"' );
        }
    }



    /**
    * Save Label
    * @return mixed
    */
    public function saveLabel( $labelID, $label, $labelOrder ) {
        $Label = new Label( );
        $info = array( );
        $info['label']  = $label;
        $info['sorting'] = $labelOrder;
        return $Label->update( 'markaxis_event_label', $info, 'WHERE labelID = "' . (int)$labelID . '"' );
    }
}
?>