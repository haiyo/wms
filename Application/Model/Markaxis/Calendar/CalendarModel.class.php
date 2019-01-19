<?php
namespace Markaxis\Calendar;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CalendarModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarModel extends \Model {


    //properties
    protected $userInfo;


        /**
    * CalendarModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $this->userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Calendar/EventRes');

        $this->info['eventID']     = 0;
        $this->info['userID']      = 0;
        $this->info['title']       = '';
        $this->info['descript']    = '';
        $this->info['label']       = 'blue';
        $this->info['privacy']     = 0;
        $this->info['allDay']      = 0;
        $this->info['start']       = '';
        $this->info['end']         = '';
        $this->info['email']       = 0;
        $this->info['popup']       = 1;
        $this->info['recur']       = 0;
        $this->info['recurType']   = 0;
        $this->info['repeatTimes'] = 0;
        $this->info['endRecur']    = '';
        $this->info['occurrences'] = 0;
        $this->info['untilDate']   = '';

        $this->setInfo['tableList']     = 'markaxis_event';
        $this->setInfo['calTitle']      = $this->L10n->getContents('LANG_DEFAULT_TITLE');
        $this->setInfo['calView']       = 'month';
        $this->setInfo['calHeight']     = '1';
        $this->setInfo['weekStart']     = '0';
        $this->setInfo['showWeekends']  = '1';
	}


    /**
    * Retrieve Calendar info by default
    * @return mixed
    */
    public function getCalByDefault( ) {
        $Calendar = new Calendar( );
        return $Calendar->getCalByDefault( $this->userInfo['userID'] );
    }


    /**
    * Get Calendar info By calID
    * @return mixed[]
    */
    public function getByCalID( $calID ) {
        $Calendar = new Calendar( );
        return $Calendar->getByCalID( $calID );
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
                while( list( $userID, $value ) = each( $setInfo['people'] ) ) {
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
        $Calendar = new Calendar( );
        return $Calendar->getEventIDByCalID( $calID );
    }


    /**
    * Load a single event
    * @return bool
    */
    public function loadEvent( $eventID /*, $startDate='', $endDate=''*/ ) {
        $Calendar = new Calendar( );
        if( !$this->info = $Calendar->getEventByID( $eventID ) ) {
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
    * Set new event info on POST
    * @return bool
    */
    public function validate( $info ) {
        $this->info['data'] = explode( '&', $info['data'] );
        $sizeOf    = sizeof( $this->info['data'] );
        $startTime = '';
        $endTime   = '';
        
        for( $i=0; $i<$sizeOf; $i++ ) {
            preg_match( '/(.*)=(.*)/', $this->info['data'][$i], $match );

            switch( $match[1] ) {
                case 'title' :
                $this->info['title'] = trim( urldecode( $match[2] ) );
                if( $this->info['title'] == '' ) {
                    $this->setErrMsg( $this->L10n->getContents('LANG_ENTER_TITLE') );
                    return false;
                }
                unset( $this->info['data'][$i] );
                break;
                
                case 'allDay'  :
                case 'eventID' :
                case 'calID' :
                case 'hasRecur' :
                case 'occurrences' :
                case 'privacy' :
                $this->info[$match[1]] = (int)$match[2];
                unset( $this->info['data'][$i] );
                break;

                case 'repeatTimes' :
                $this->info[$match[1]] = (int)$match[2];
                if( $this->info['repeatTimes'] < 1 ) $this->info['repeatTimes'] = 1;
                unset( $this->info['data'][$i] );
                break;

                case 'startMonth' :
                case 'startDay'   :
                case 'startYear'  :
                case 'endMonth'   :
                case 'endDay'     :
                case 'endYear'    :
                $$match[1] = (int)$match[2];
                unset( $this->info['data'][$i] );
                break;

                case 'startTime' :
                case 'endTime' :
                if( preg_match( '/(\d{4})/', $match[2] ) ) {
                    $$match[1] = $match[2];
                    unset( $this->info['data'][$i] );
                }
                break;

                case 'email' :
                case 'popup' :
                if( in_array( $match[2], ReminderHelper::getList( ) ) ) {
                    $this->info[$match[1]] = $match[2];
                    unset( $this->info['data'][$i] );
                }
                break;

                case 'recurType' :
                if( in_array( $match[2], RecurHelper::getList( ) ) ) {
                    $this->info['recur']   = $match[2] == '' ? 0 : 1;
                    $this->info[$match[1]] = $match[2];
                    if( $this->info['repeatTimes'] < 1 || $this->info['recurType'] == 'weekday' ||
                        $this->info['recurType'] == 'monWedFri' || $this->info['recurType'] == 'tueThur' )
                    $this->info['repeatTimes'] = 1;
                    unset( $this->info['data'][$i] );
                }
                break;

                case 'endRecur' :
                if( in_array( $match[2], EndRecurHelper::getList( ) ) ) {
                    $this->info[$match[1]] = $match[2];
                    unset( $this->info['data'][$i] );
                }
                break;

                case 'label' :
                if( in_array( $match[2], LabelHelper::getList( ) ) ) {
                    $this->info[$match[1]] = $match[2];
                    unset( $this->info['data'][$i] );
                }
                break;

                case 'untilDate' :
                if( $match[2] != '' ) {
                    $date = explode( '-', urldecode( $match[2] ) );
                    if( isset( $date[0] ) && isset( $date[1] ) && isset( $date[2] ) && checkdate( $date[1], $date[2], $date[0] ) ) {
                        $date[2] = strlen( $date[2] ) == 1 ? 0 . $date[2] : $date[2];
                        $date[1] = strlen( $date[1] ) == 1 ? 0 . $date[1] : $date[1];
                        $date = $date[0] . '-' . $date[1] . '-' . $date[2];
                        $this->info[$match[1]] = $date;
                        unset( $this->info['data'][$i] );
                    }
                }
                break;
            }
        }

        if( $this->info['descript'] == '<br>' ) {
            $this->info['descript'] = '';
        }
        else {
            $this->info['descript'] = trim( strip_tags( $info['descript'], '<p><br><span><font><b><i><u><ul><li><ol><div>') );
        }
        $unixStart = strtotime( $startYear . '-' . $startMonth . '-' . $startDay . ' ' . $startTime );
        $unixEnd   = strtotime( $endYear . '-' . $endMonth . '-' . $endDay . ' ' . $endTime );
        $this->info['start'] = date( 'Y-m-d H:i', $unixStart );
        $this->info['end']   = date( 'Y-m-d H:i', $unixEnd   );
        $this->info['data']  = array_values( $this->info['data'] );
        return true;
    }


    /**
    * Retrieve Events Between a Start and End Timestamp
    * @return mixed
    */
    public function getTableList( ) {
        $Calendar = new Calendar( );
        return $Calendar->getTableList( );
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
        $Calendar = new Calendar( );
        if( isset( $info['allDay'] ) && $info['allDay'] == 'true' ) {
            $info['end'] = strtotime( date( 'Y-m-d 23:59:59', $info['end'] ) );
        }
        return $Calendar->getEventsBetween( $info['calID'],
                                            date( 'Y-m-d H:i:s', $info['start'] ),
                                            date( 'Y-m-d H:i:s', $info['end'] ) );
    }


    /**
    * Retrieve recurring events
    * @return mixed
    */
    public function getRecurs( $info ) {
        $Calendar = new Calendar( );
        $effective = array( );
        $eventInfo = $Calendar->getRecurs( $info['calID'] );
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
        $Calendar = new Calendar( );
        $param = array( );
        $param['calID']    = $this->info['calID'];
        $param['userID']   = $this->userInfo['userID'];
        $param['title']    = $this->info['title'];
        $param['descript'] = $this->info['descript'];
        $param['privacy']  = $this->info['privacy'];
        $param['allDay']   = $this->info['allDay'];
        $param['start']    = $this->info['start'];
        $param['end']      = $this->info['end'];
        $param['recur']    = $this->info['recur'];
        $param['label']    = $this->info['label'];
        $param['email']    = $this->info['email'];
        $param['popup']    = $this->info['popup'];

        if( $this->info['eventID'] == 0 ) {
            $this->info['eventID']  = $Calendar->insert( 'markaxis_event', $param );
            $this->info['saveType'] = 'add';
        }
        else {
            $Calendar->update( 'markaxis_event', $param, 'WHERE eventID = "' . (int)$this->info['eventID'] . '"' );
            $this->info['saveType'] = 'update';
        }

        if( $this->info['recur'] ) {
            $recur = array( );
            $recur['eventID']     = $this->info['eventID'];
            $recur['recurType']   = $this->info['recurType'];
            $recur['repeatTimes'] = $this->info['repeatTimes'];
            if( $this->info['endRecur']    ) $recur['endRecur']    = $this->info['endRecur'];
            if( $this->info['occurrences'] ) $recur['occurrences'] = $this->info['occurrences'];
            if( $this->info['untilDate']   ) $recur['untilDate']   = $this->info['untilDate'];

            if( $this->info['hasRecur'] ) {
                $Calendar->update( 'markaxis_event_recur', $recur, 'WHERE eventID = "' . (int)$this->info['eventID'] . '"' );
            }
            else {
                $Calendar->insert( 'markaxis_event_recur', $recur );
            }
        }
        else if( $this->info['hasRecur'] ) {
            $Calendar->delete( 'markaxis_event_recur', 'WHERE eventID = "' . (int)$this->info['eventID'] . '"' );
        }
        return true;
    }


    /**
    * Update an event on user drag
    * @return bool
    */
    public function updateEventDrag( $post ) {
        if( $this->loadEvent( $post['eventID'] ) ) {
            $Calendar = new Calendar( );
            $param = array( );
            $param['start'] = $post['start'];
            $param['end']   = $post['end'] != '' ? $post['end'] : $post['start'];
            if( isset( $post['allDay'] ) ) { $param['allDay'] = (int)$post['allDay']; }
            $Calendar->update( 'markaxis_event', $param, 'WHERE eventID = "' . (int)$post['eventID'] . '"' );
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

                $Calendar = new Calendar( );
                $Calendar->delete( 'markaxis_event', 'WHERE eventID = "' . (int)$this->info['eventID'] . '" AND
                                                            userID = "' . (int)$this->userInfo['userID'] . '"' );
                return true;
            }
        }
        $this->setErrMsg( $this->L10n->getContents('LANG_NO_PERM') );
        return false;
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