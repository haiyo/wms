<?php
namespace Markaxis\Calendar;
use \Aurora\User\UserModel;
use \Library\Helper\Markaxis\LabelHelper;
use \Library\Helper\Markaxis\RecurHelper, \Library\Helper\Markaxis\ReminderHelper;
use \Library\Validator\Validator;
use \DateTime;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CalendarModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarModel extends \Model {


    //properties
    protected $Calendar;


        /**
    * CalendarModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Calendar/EventRes');

        $this->Calendar = new Calendar( );

        $this->info['eID']         = 0;
        $this->info['title']       = '';
        $this->info['descript']    = '';
        $this->info['label']       = 'blue';
        $this->info['privacy']     = 0;
        $this->info['allDay']      = 0;
        $this->info['start']       = '';
        $this->info['end']         = '';
        $this->info['reminder']    = 0;
        $this->info['recurType']   = 0;
	}


    /**
    * Retrieve Calendar info by default
    * @return mixed
    */
    public function getCalByDefault( ) {
        return $this->Calendar->getCalByDefault( $this->userInfo['userID'] );
    }


    /**
    * Get Calendar info By calID
    * @return mixed[]
    */
    public function getByCalID( $calID ) {
        return $this->Calendar->getByCalID( $calID );
    }


    /**
     * Retrieve Labels by UserID
     * @return mixed
     */
    public function getLabels( ) {
        $Label = new Label( );
        return $Label->getLabels( );
    }


    /**
    * Get Owner Calendar
    * @return mixed[]
    */
    public function getOwnerCal( ) {
        $calInfo = $this->getByCalID( $this->info['calID'] );

        if( $calInfo['parentID'] != 0 ) {
            // Get real owner
            $calInfo = $this->getByCalID( $calInfo['parentID'] );
        }
        return $calInfo;
    }


    /**
    * Check if user can manage sharing on calendar
    * @return bool
    */
    public function getCalPerm( $calInfo ) {
        if( $calInfo['parentID'] != 1 ) { // not public
            if( $calInfo['ownerID'] == $this->userInfo['userID'] ) {
                return 'changeShare';
            }
            $setInfo = unserialize( $calInfo['settings'] );

            if( isset( $setInfo['people'] ) ) {
                foreach( $setInfo['people'] as $userID => $value ) {
                    if( $userID == $this->userInfo['userID'] ) {
                        return $value['perm'];
                    }
                }
            }
        }
        return false;
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
    * Get all events by calID
    * @return mixed[]
    */
    public function getEventIDByCalID( $calID ) {
        return $this->Calendar->getEventIDByCalID( $calID );
    }


    /**
    * Load a single event
    * @return bool
    */
    public function loadEvent( $eventID /*, $startDate='', $endDate=''*/ ) {
        if( !$this->info = $this->Calendar->getEventByID( $eventID ) ) {
            return false;
        }
        // In the event when user A changes the event date, user B might still be
        // looking at the old. Hence do a check to make sure the date is correct
        // NOTE: Doesn't work on recurring :/
        /*if( $startDate ) {
            if( date('Y-m-d', strtotime( $startDate ) ) != date('Y-m-d', strtotime( $this->info['start'] ) ) ) {
                return false;
            }
        }*/
        return true;
    }


    /**
     * Set Pay Item Info
     * @return bool
     */
    public function isValid( $data ) {
        $this->info['eID'] = (int)$data['eID'];
        $this->info['title'] = Validator::stripTrim( $data['title'] );
        $this->info['descript'] = Validator::stripTrim( $data['descript'] );
        $this->info['allDay']  = ( isset( $data['allDay']  ) && $data['allDay']  ) ? 1 : 0;
        $this->info['privacy'] = ( isset( $data['privacy'] ) && $data['privacy'] ) ? 1 : 0;

        if( !$this->info['title'] || !$this->info['descript'] ) {
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

        if( $data['recurType'] ) {
            if( in_array( $data['recurType'], RecurHelper::getList() ) ) {
                $this->info['recurType'] = $data['recurType'];
            }
            else {
                $this->setErrMsg( $this->L10n->getContents('LANG_PROVIDE_ALL_REQUIRED') );
                return false;
            }
        }

        if( $data['reminder'] ) {
            if( in_array( $data['reminder'], ReminderHelper::getList() ) ) {
                $this->info['reminder'] = $data['reminder'];
            }
            else {
                $this->setErrMsg( $this->L10n->getContents('LANG_PROVIDE_ALL_REQUIRED') );
                return false;
            }
        }

        if( $data['label'] ) {
            if( in_array( $data['label'], LabelHelper::getList( ) ) ) {
                $this->info['label'] = $data['label'];
            }
            else {
                $this->setErrMsg( $this->L10n->getContents('LANG_PROVIDE_ALL_REQUIRED') );
                return false;
            }
        }

        $userInfo = UserModel::getInstance( )->getInfo( );
        $this->info['userID'] = $userInfo['userID'];
        $this->info['created'] = date( 'Y-m-d H:i:s' );
        return true;
    }


    /**
    * Retrieve Events Between a Start and End Timestamp
    * @return mixed
    */
    public function getTableList( ) {
        return $this->Calendar->getTableList( );
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
    * Retrieve Events Between a Start and End Timestamp
    * @return mixed
    */
    public function getEvents( $info ) {
        if( isset( $info['allDay'] ) && $info['allDay'] == 'true' ) {
            $info['end'] = strtotime( date( 'Y-m-d 23:59:59', $info['end'] ) );
        }
        return $this->Calendar->getEventsBetween( $info['calID'],
                                                  date( 'Y-m-d H:i:s', $info['start'] ),
                                                  date( 'Y-m-d H:i:s', $info['end'] ) );
    }


    /**
    * Retrieve recurring events
    * @return mixed
    */
    public function getRecurs( $info ) {
        $effective = array( );
        $eventInfo = $this->Calendar->getRecurs( $info['calID'] );
        $size = sizeof( $eventInfo );

        for( $i=0; $i<$size; $i++ ) {
            if( $eventInfo[$i]['recurType'] === 'day' ) {
                $DayRecur = new DayRecur( $info['start'], $info['end'] );
                $DayRecur->setEvent( new Event( $eventInfo[$i] ) );
                $effective[] = $DayRecur->getEvents( );
            }
            else if( $eventInfo[$i]['recurType'] === 'week' ) {
                $WeekRecur = new WeekRecur( $info['start'], $info['end'] );
                $WeekRecur->setEvent( new Event( $eventInfo[$i] ) );
                $effective[] = $WeekRecur->getEvents( );
            }
            else if( $eventInfo[$i]['recurType'] === 'weekday' ) {
                $WeekDayRecur = new WeekDayRecur( $info['start'], $info['end'] );
                $WeekDayRecur->setEvent( new Event( $eventInfo[$i] ) );
                $effective[] = $WeekDayRecur->getEvents( );
            }
            else if( $eventInfo[$i]['recurType'] === 'monWedFri' ) {
                $NDayRecur = new NDayRecur( $info['start'], $info['end'] );
                $NDayRecur->setNDay( array(1,3,5) );
                $NDayRecur->setEvent( new Event( $eventInfo[$i] ) );
                $effective[] = $NDayRecur->getEvents( );
            }
            else if( $eventInfo[$i]['recurType'] === 'tueThur' ) {
                $NDayRecur = new NDayRecur( $info['start'], $info['end'] );
                $NDayRecur->setNDay( array(2,4) );
                $NDayRecur->setEvent( new Event( $eventInfo[$i] ) );
                $effective[] = $NDayRecur->getEvents( );
            }
            else if( $eventInfo[$i]['recurType'] === 'month' ) {
                $MonthRecur = new MonthRecur( $info['start'], $info['end'] );
                $MonthRecur->setEvent( new Event( $eventInfo[$i] ) );
                $effective[] = $MonthRecur->getEvents( );
            }
            else if( $eventInfo[$i]['recurType'] === 'year' ) {
                $YearRecur = new YearRecur( $info['start'], $info['end'] );
                $YearRecur->setEvent( new Event( $eventInfo[$i] ) );
                $effective[] = $YearRecur->getEvents( );
            }
        }
        return $effective;
    }


    /**
    * Save Event
    * @return mixed
    */
    public function save( ) {
        if( $this->info['eID'] == 0 ) {
            $this->info['eID']  = $this->Calendar->insert( 'markaxis_event', $this->info );
        }
        else {
            // and userID
            $this->Calendar->update('markaxis_event', $this->info,
                                    'WHERE eID = "' . (int)$this->info['eID'] . '" AND
                                                  userID = "' . (int)$this->info['userID'] . '"' );
        }

        /*if( $this->info['recur'] ) {
            $recur = array( );
            $recur['eventID']     = $this->info['eventID'];
            $recur['recurType']   = $this->info['recurType'];
            $recur['repeatTimes'] = $this->info['repeatTimes'];
            if( $this->info['endRecur']    ) $recur['endRecur']    = $this->info['endRecur'];
            if( $this->info['occurrences'] ) $recur['occurrences'] = $this->info['occurrences'];
            if( $this->info['untilDate']   ) $recur['untilDate']   = $this->info['untilDate'];

            if( $this->info['hasRecur'] ) {
                $this->Calendar->update( 'markaxis_event_recur', $recur, 'WHERE eventID = "' . (int)$this->info['eventID'] . '"' );
            }
            else {
                $this->Calendar->insert( 'markaxis_event_recur', $recur );
            }
        }
        else if( $this->info['hasRecur'] ) {
            $this->Calendar->delete( 'markaxis_event_recur', 'WHERE eventID = "' . (int)$this->info['eventID'] . '"' );
        }*/
        return true;
    }


    /**
    * Update an event on user drag
    * @return bool
    */
    public function updateEventDrag( $post ) {
        if( $this->loadEvent( $post['eventID'] ) ) {
            $param = array( );
            $param['start'] = $post['start'];
            $param['end']   = $post['end'] != '' ? $post['end'] : $post['start'];
            if( isset( $post['allDay'] ) ) { $param['allDay'] = (int)$post['allDay']; }
            $this->Calendar->update( 'markaxis_event', $param, 'WHERE eventID = "' . (int)$post['eventID'] . '"' );
            return true;
        }
    }


    /**
    * Delete an event
    * @return bool
    */
    public function deleteEvent( $post ) {
        if( $this->loadEvent( $post['eventID'] ) ) {
            $calInfo = $this->getOwnerCal( );

            $Authorization = $this->Registry->get( HKEY_CLASS, 'Authorization' );

            // if public
            if( $calInfo['parentID'] == 1 ) {
                if( !$Authorization->isAdmin( ) || $calInfo['userID'] != $this->userInfo['userID'] ) {
                    $this->setErrMsg( $this->L10n->getContents('LANG_NO_PERM') );
                    return false;
                }
                $perm = 'changeShare';
            }
            else {
                $perm = $this->getCalPerm( $calInfo );
            }

            if( $perm == 'changeShare' ) {
                $CalendarAttachmentModel = new CalendarAttachmentModel( );
                $CalendarAttachmentModel->deleteAllFilesByEventID( );

                $this->Calendar->delete( 'markaxis_event', 'WHERE eventID = "' . (int)$this->info['eventID'] . '" AND
                                                            userID = "' . (int)$this->userInfo['userID'] . '"' );
                return true;
            }
        }
        $this->setErrMsg( $this->L10n->getContents('LANG_NO_PERM') );
        return false;
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