<?php
namespace Markaxis\Calendar;
use \Library\Runtime\Registry, \Aurora\Admin\AdminView, \Aurora\Form\SelectListView, \Aurora\Form\CheckboxView;
use \Aurora\DayIntListView, Aurora\YearListView, Aurora\MonthHelper, Aurora\TimeHelper;
use \Aurora\RadioView, Aurora\PermListView, Aurora\YesNoRadioView, Aurora\UserAvatarView;
use \Aurora\RoleListView;
use \Library\IO\File;
use \Date, \Stringify;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, July 7th, 2012
 * @version $Id: CalendarView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $CalendarRes;
    protected $EventRes;
    protected $CalendarModel;


    /**
    * CalendarView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->HKEY_LOCAL = $this->Registry->get( HKEY_LOCAL );

        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->CalendarRes = $i18n->loadLanguage('Markaxis/Calendar/CalendarRes');
        $this->EventRes    = $i18n->loadLanguage('Markaxis/Calendar/EventRes');

        $this->CalendarModel = CalendarModel::getInstance( );

        $this->setJScript( array( 'plugins/moment' => 'moment.min.js',
                                  'plugins/fullcalendar' => array( 'core/main.js',
                                                                   'daygrid/main.js',
                                                                   'timegrid/main.js',
                                                                   'interaction/main.js' ) ) );

        $this->setStyle( array( 'fullcalendar' => array( 'core/main', 'daygrid/main', 'timegrid/main' ) ) );
	}


    /**
     * Render Tab
     * @return string
     */
    public function renderUpcomingEvents( ) {
        $vars = array_merge( $this->EventRes->getContents( ), array( ) );

        $vars['dynamic']['noEvent'] = true;
        $vars['dynamic']['event'] = false;

        return $this->View->render( 'markaxis/calendar/upcomingEvent.tpl', $vars );
    }


    /**
    * Render Tab
    * @return string
    */
    public function renderFormTab( ) {
        $html = '';
        $tab  = array( 'general' => $this->EventRes->getContents('LANG_GENERAL'),
                       'other'   => $this->EventRes->getContents('LANG_REMINDER_REPEAT') );

        foreach( $tab as $id => $title ) {
            $vars = array( 'TPVAR_TAB_ID' => $id,
                           'LANG_TITLE'   => $title );
            $html .= $this->View->render( 'markaxis/calendar/html/tab.tpl', $vars );
        }
        return $html;
    }


    /**
    * Render Calendar Table
    * @return mixed
    */
    public function renderCalendar( $date ) {
        /*$calInfo  = $this->CalendarModel->getCalByDefault( );
        $setInfo  = unserialize( $calInfo['settings'] );
        $editAble = 1;
        
        if( $calInfo['parentID'] != 0 ) {
            // Get real owner
            $ownerCal = $this->CalendarModel->getByCalID( $calInfo['parentID'] );
            $ownerSet = unserialize( $ownerCal['settings'] );

            if( isset( $ownerSet['people'] ) ) {
                foreach( $ownerSet['people'] as $userID => $value ) {
                    if( $userID == $this->userInfo['userID'] ) {
                        if( $value['perm'] == 'viewAll' ) {
                            $editAble = 0;
                        }
                    }
                }
            }
        }
        $vars = array( 'TPLVAR_CALID'        => $calInfo['calID'],
                       'TPLVAR_PARENT_CALID' => $calInfo['parentID'],
                       'TPLVAR_CAL_VIEW'     => 'month',
                       'TPLVAR_CAL_RATIO'    => $setInfo['calHeight'],
                       'TPLVAR_CAL_STARTS'   => $setInfo['weekStart'],
                       'TPLVAR_CAL_WEEKENDS' => $setInfo['showWeekends'],
                       'TPLVAR_CAL_EDITABLE' => $editAble );
        
        return array( 'title' => $this->EventRes->getContents('LANG_DEFAULT_TITLE'),
                      'calendar' => $this->render( 'markaxis/calendar/html/droplet.tpl', $vars ) );*/

        $this->setBreadcrumbs( array( 'link' => 'admin/calendar',
                                      'icon' => 'icon-users4',
                                      'text' => $this->CalendarRes->getContents('LANG_MY_CALENDAR') ) );

        $vars = array_merge( $this->CalendarRes->getContents( ), array( 'LANG_LINK' => $this->CalendarRes->getContents('LANG_MY_CALENDAR') ) );

        return $this->render( 'markaxis/calendar/calendar.tpl', $vars );
    }


    /**
    * Render Event List
    * @return string
    */
    public function renderEventList( $info ) {
        $param['calID']     = $info[4];
        $param['allDay']    = $info[3];
        $param['start']     = strtotime( $info[1] );
        $param['end']       = strtotime( $info[2] );
        $param['currMonth'] = date( 'm', $param['end'] );
        $param['currYear']  = date( 'Y', $param['end'] );
        $eInfo = $this->CalendarModel->getEvents( $param );
        $rInfo = $this->CalendarModel->getRecurs( $param );
        $sizeR = sizeof( $rInfo );

        for( $i=0; $i<$sizeR; $i++ ) {
            $eInfo = array_merge( $eInfo, $rInfo[$i] );
        }
        $size = sizeof( $eInfo );
        $vars = array( 'TPLVAR_CALID'   => $param['calID'],
                       'TPLVAR_START'   => $info[1], // Give original format to template
                       'TPLVAR_END'     => $info[2], // Give original format to template
                       'TPLVAR_ALL_DAY' => $param['allDay'] );

        $vars['dynamic']['list'] = false;

        $String = new Stringify( );
        $dateRange = Date::dateRangeArray( $param['start'], $param['end'] );

        $class = '';
        $type  = RecurHelper::getL10nList( );

        foreach( $dateRange as $date ) {
            $dateArray = explode( '-', $date );
            $list  = '';
            $class = $class == '' ? 'bgList' : '';

            $UserAvatarView = new UserAvatarView( );
            $majorityType   = array( );

            for( $i=0; $i<$size; $i++ ) {
                if( Date::inRange( $eInfo[$i]['start'], $eInfo[$i]['end'], $date ) ) {            
                    $repeatType = $eInfo[$i]['recur'] ? $type[$eInfo[$i]['recurType']] : '';
                    $reminder   = 'none';
                    if( $eInfo[$i]['email'] || $eInfo[$i]['popup'] ) { $reminder = ''; }
                    if( isset( $majorityType[$eInfo[$i]['className']] ) ) {
                        $majorityType[$eInfo[$i]['className']]++;
                    }
                    else {
                        $majorityType[$eInfo[$i]['className']] = 1;
                    }
                    $vars2 = array( 'TPLVAR_EVENT_ID'     => $eInfo[$i]['eventID'],
                                    'TPLVAR_START'        => $eInfo[$i]['start'],
                                    'TPLVAR_END'          => $eInfo[$i]['end'],
                                    'TPLVAR_ETITLE'       => nl2br( $String->makeLink( htmlspecialchars( $eInfo[$i]['eTitle'] ) ) ),
                                    'TPL_AVATAR'          => $UserAvatarView->renderAvatar( $eInfo[$i], 'micro' ),
                                    'TPLVAR_USERID'       => $eInfo[$i]['userID'],
                                    'TPLVAR_FNAME'        => $eInfo[$i]['fname'],
                                    'TPLVAR_LNAME'        => $eInfo[$i]['lname'],
                                    'TPLVAR_ROLE_TITLE'   => $eInfo[$i]['roleTitle'],
                                    'TPLVAR_LABEL'        => $eInfo[$i]['className'],
                                    'TPLVAR_LABEL_TYPE'   => $eInfo[$i]['labelType'],
                                    'TPLVAR_REPEAT_TYPE'  => $repeatType,
                                    'TPLVAR_REMINDER'     => $reminder,
                                    'TPLVAR_RECUR'        => $eInfo[$i]['recur'] ? '' : 'none',
                                    'TPLVAR_PRIVACY_ICON' => $eInfo[$i]['privacy'] ? 'lock' : 'unlock',
                                    'TPLVAR_DISPLAY_ATT'  => $eInfo[$i]['attachment'] ? '' : 'none',
                                    'TPLVAR_DISPLAY_ADD'  => $eInfo[$i]['address'] ? '' : 'none',
                                    'TPLVAR_DISPLAY_RSVP' => $eInfo[$i]['rsvp'] ? '' : 'none',
                                    'TPLVAR_ADDRESS'      => $eInfo[$i]['address'],
                                    'LANG_RSVP'           => $this->EventRes->getContents('LANG_RSVP'),
                                    'LANG_NUM_ATTACHMENT' => $this->EventRes->getText('LANG_NUM_ATTACHMENT', $eInfo[$i]['attachment'] ),
                                    'LANG_FULL_DAY'       => $this->EventRes->getContents('LANG_FULL_DAY'),
                                    'LANG_PRIVACY'        => $eInfo[$i]['privacy'] ? $this->EventRes->getContents('LANG_PRIVATE_EVENT_BY') :
                                                                                     $this->EventRes->getContents('LANG_PUBLIC_EVENT_BY'),);

                    $vars2['dynamic']['time']   = false;
                    $vars2['dynamic']['allDay'] = false;
                    if( $eInfo[$i]['allDay'] ) {
                        $vars2['dynamic']['allDay'][] = true;
                    }
                    else {
                        $vars2['dynamic']['time'][] = array( 'TPLVAR_START_TIME' => date( $this->HKEY_LOCAL['timeFormat'], strtotime( $eInfo[$i]['start'] ) ),
                                                             'TPLVAR_END_TIME'   => date( $this->HKEY_LOCAL['timeFormat'], strtotime( $eInfo[$i]['end'] ) ) );
                    }
                    $list .= $this->View->render( 'markaxis/calendar/html/eventList.tpl', $vars2 );
                }
            }
            if( $list == '' ) {
                $list  = $this->EventRes->getContents('LANG_EVENT_NO_RECORD');
                $label = 'grey';
            }
            else {
                $label = array_search( max( $majorityType ), $majorityType );
            }
            $toTime = strtotime( $date );
            $today = date( 'Y-m-d' );
            $day   = $date != $today ? date( 'l', $toTime ) : $this->CalendarRes->getContents('LANG_TODAY');
            $vars['dynamic']['list'][] = array( 'TPLVAR_DATE_ID'    => $date,
                                                'TPLVAR_DAY_DATE'   => $dateArray[2],
                                                'TPLVAR_DAY'        => $day,
                                                'TPLVAR_MONTH'      => date('M', $toTime),
                                                'TPLVAR_LABEL'      => $label,
                                                'TPL_EVENT_LIST'    => $list,
                                                'TPLVAR_BG_CLASS'   => $class,
                                                'LANG_REMINDER_SET' => $this->CalendarRes->getContents('LANG_REMINDER_SET'),
                                                'LANG_REPEAT'       => $this->CalendarRes->getContents('LANG_REPEAT') );
        }
        $btn = array( );
        $btn['create'] = array( 'text'  => $this->EventRes->getContents('LANG_CREATE_NEW_EVENT') );
        $this->View->setTitle( $this->EventRes->getContents('LANG_AGENDA_LIST') );
        $this->View->setStyle( array( 'markaxis/calendar' => 'event' ) );
        $this->View->setJScript( array( 'markaxis.agenda' => 'markaxis/calendar/markaxis.agenda.js' ) );
        $this->View->setButtons( $btn );
        return $this->View->render( 'markaxis/calendar/html/event.tpl', $vars );
    }


    /**
    * Render User List
    * @return mixed
    */
    public function renderUserList( $type, $userList ) {
        $list = array( );
        $list['num']  = 0;
        $list['html'] = '';

        if( sizeof( $userList ) > 0 ) {
            $UserAvatarView = new UserAvatarView( );

            foreach( $userList as $value ) {
                if( $value['attending'] == $type ) {
                    $list['html'] .= $UserAvatarView->renderAvatar( $value, 'micro' );
                    $list['num']++;
                }
            }
        }
        return $list;
    }


    /**
    * Render Agenda
    * @return string
    */
    public function renderAgenda( ) {
        $eventInfo  = $this->CalendarModel->getInfo( );
        $repeatType = '';
        if( $eventInfo['recur'] ) {
            $RecurHelper = RecurHelper::getL10nList( );
            $repeatType  = $RecurHelper[$eventInfo['recurType']];
        }

        $String = new String( );
        $vars = array( 'TPLVAR_EVENT_ID'      => $eventInfo['eventID'],
                       'TPLVAR_ETITLE'        => nl2br( $String->makeLink( htmlspecialchars( $eventInfo['eTitle'] ) ) ),
                       'TPLVAR_DESCRIPT'      => nl2br( $String->makeLink( htmlspecialchars( $eventInfo['descript'] ) ) ),
                       'TPLVAR_USERID'        => $eventInfo['userID'],
                       'TPLVAR_FNAME'         => $eventInfo['fname'],
                       'TPLVAR_LNAME'         => $eventInfo['lname'],
                       'TPLVAR_ROLE_TITLE'    => $eventInfo['roleTitle'],
                       'TPLVAR_LABEL'         => $eventInfo['className'],
                       'TPLVAR_LABEL_TYPE'    => $eventInfo['labelType'],
                       'TPLVAR_REPEAT_TYPE'   => $repeatType,
                       'TPLVAR_RECUR'         => $eventInfo['recur'] ? '' : 'none',
                       'TPLVAR_DESCRIPT_SHOW' => $eventInfo['descript'] ? '' : 'none',
                       'TPLVAR_PRIVACY_ICON'  => $eventInfo['privacy'] ? 'lock' : 'unlock',
                       'LANG_PRIVACY'         => $eventInfo['privacy'] ? $this->EventRes->getContents('LANG_PRIVATE_EVENT_BY') :
                                                                         $this->EventRes->getContents('LANG_PUBLIC_EVENT_BY'),
                       'LANG_REMINDER_SET'    => $this->CalendarRes->getContents('LANG_REMINDER_SET'),
                       'LANG_REPEAT'          => $this->CalendarRes->getContents('LANG_REPEAT'),
                       'LANG_WRITE_MESSAGE'   => $this->EventRes->getContents('LANG_WRITE_MESSAGE'),
                       'LANG_UNTIL'           => $this->EventRes->getContents('LANG_UNTIL'),
                       'LANG_FULL_DAY'        => $this->EventRes->getContents('LANG_FULL_DAY') );

        $vars['dynamic']['time']   = false;
        $vars['dynamic']['allDay'] = false;
        if( $eventInfo['allDay'] ) {
            $vars['dynamic']['allDay'][] = true;
        }
        else {
            $daysDiff = Date::daysDiff( $eventInfo['start'], $eventInfo['end'] );

            if( $daysDiff > 0 ) {
                $vars['dynamic']['time'][] = array( 'TPLVAR_START_TIME' => date( 'j M h:ia', strtotime( $eventInfo['start'] ) ),
                                                    'TPLVAR_END_TIME'   => date( 'j M h:ia', strtotime( $eventInfo['end'] ) ) );
            }
            else {
                $vars['dynamic']['time'][] = array( 'TPLVAR_START_TIME' => date( 'h:ia', strtotime( $eventInfo['start'] ) ),
                                                    'TPLVAR_END_TIME'   => date( 'h:ia', strtotime( $eventInfo['end'] ) ) );
            }
        }
        $this->View->setStyle( array( 'markaxis/calendar' => 'event' ) );
        $this->View->setJScript( array( 'markaxis.agenda' => 'markaxis/calendar/markaxis.agenda.js' ) );
        return $this->View->render( 'markaxis/calendar/html/agenda.tpl', $vars );
    }


    /**
    * Render Agenda Tab
    * @return string
    */
    public function renderAgendaTab( ) {
        $eventInfo = $this->CalendarModel->getInfo( );

        if( $eventInfo['descript'] != '' ) {
            $vars = array( 'TPVAR_TAB_ID' => 'descript',
                           'LANG_TITLE'   => $this->EventRes->getContents('LANG_DESCRIPTION') );
            return $this->View->render( 'markaxis/calendar/html/tab.tpl', $vars );
        }
    }


    /**
    * Render Agenda Tab Data
    * @return string
    */
    public function renderAgendaTabData( ) {
        $eventInfo = $this->CalendarModel->getInfo( );

        if( $eventInfo['descript'] != '' ) {
            $vars = array( 'TPLVAR_DESCRIPT' => $eventInfo['descript'] );
            $this->View->setJScript( array( 'markaxis.agendaDescript' => 'markaxis/calendar/markaxis.agendaDescript.js' ) );
            return $this->View->render( 'markaxis/calendar/html/agendaDescript.tpl', $vars );
        }
    }


    /**
    * Render Event Form
    * @return string
    */
    public function renderEventForm( ) {
        $info = $this->CalendarModel->getInfo( );

        $SelectListView = new SelectListView( );
        $SelectListView->setClass('selectList');
        $unixStart = strtotime( $info['start'] );
        $unixEnd   = strtotime( $info['end'] );
        
        $startMonth = $SelectListView->build( 'startMonth', MonthHelper::getL10nList( ), date('m', $unixStart ) );
        $endMonth   = $SelectListView->build( 'endMonth',   MonthHelper::getL10nList( ), date('m', $unixEnd ) );
        $startTime  = $SelectListView->build( 'startTime',  TimeHelper::getL10nList( ),  date('Hi', $unixStart ) );
        $endTime    = $SelectListView->build( 'endTime',    TimeHelper::getL10nList( ),  date('Hi', $unixEnd ) );
        $recurring  = $SelectListView->build( 'recurType',  RecurHelper::getL10nList( ), $info['recurType'] );
        $endRecur   = $SelectListView->build( 'endRecur',   EndRecurHelper::getL10nList( ), $info['endRecur'] );

        $DayIntListView = new DayIntListView( );
        $DayIntListView->setClass('selectList');
        $startDay = $DayIntListView->getList( 'startDay', date('d', $unixStart ) );
        $endDay   = $DayIntListView->getList( 'endDay',   date('d', $unixEnd ) );
        $DayIntListView->setClass('selectList repeatList');
        $repeat = $DayIntListView->getList( 'repeatTimes', $info['repeatTimes'] );

        $YearListView = new YearListView( );
        $YearListView->setClass('selectList');
        $startYear = $YearListView->getList( 'startYear', date('Y', $unixStart ) );
        $endYear   = $YearListView->getList( 'endYear',   date('Y', $unixEnd ) );

        $RadioView = new RadioView( );
        $privacy = $RadioView->build( 'privacy', PrivacyHelper::getL10nList( ), $info['privacy'] );

        $allDay = $info['allDay'] == 'true' ? 1 : 0;

        $CheckboxView = new CheckboxView( );
        $allDay = $CheckboxView->build( 'allDay', array( '1' => $this->EventRes->getContents('LANG_ALL_DAY') ), $allDay );

        $labels = $this->CalendarModel->getLabels( );

        $LabelListView = new LabelListView( );
        $labelList = $LabelListView->getList( 'label', $labels, $info['label'] );
        $email = $SelectListView->build( 'email', ReminderHelper::getL10nList( ), $info['email'] );
        $popup = $SelectListView->build( 'popup', ReminderHelper::getL10nList( ), $info['popup'] );
        $hasRecur = $info['recur'] ? 1 : 0;

        $staffID = '';
        if( isset( $info['rsvp'] ) && is_array( $info['rsvp'] ) && sizeof( $info['rsvp'] ) > 0 ) {
            foreach( $info['rsvp'] as $value ) {
                $staffID .= $value['userID'] . ',';
            }
            $staffID = substr( $staffID, 0, -1 );
        }

        $vars = array_merge( $this->EventRes->getContents( ),
                array_merge( $this->CalendarRes->getContents( ),
                array( 'TPLVAR_EVENT_ID'       => $info['eventID'],
                       'TPLVAR_EVENT_TITLE'    => $info['title'],
                       'TPLVAR_EVENT_DESCRIPT' => $info['descript'],
                       'TPLVAR_START_MONTH'    => $startMonth,
                       'TPLVAR_START_DAY'      => $startDay,
                       'TPLVAR_START_YEAR'     => $startYear,
                       'TPLVAR_START_TIME'     => $startTime,
                       'TPLVAR_END_MONTH'      => $endMonth,
                       'TPLVAR_END_DAY'        => $endDay,
                       'TPLVAR_END_YEAR'       => $endYear,
                       'TPLVAR_END_TIME'       => $endTime,
                       'TPLVAR_RECURRING'      => $recurring,
                       'TPLVAR_END_RECUR'      => $endRecur,
                       'TPLVAR_OCCURRENCES'    => $info['occurrences'],
                       'TPLVAR_UNTIL_DATE'     => $info['untilDate'],
                       'TPLVAR_PRIVACY'        => $privacy,
                       'TPLVAR_ALL_DAY'        => $allDay,
                       'TPLVAR_LABEL_LIST'     => $labelList,
                       'TPLVAR_EMAIL_REMINDER' => $email,
                       'TPLVAR_POPUP_REMINDER' => $popup,
                       'TPLVAR_REPEAT_LIST'    => $repeat,
                       //'TPLVAR_FILE_LIST'      => isset( $info['attachment'] ) ? $this->getFileList( $info['attachment'] ) : '',
                       //'TPLVAR_STAFF_ID'       => $staffID,
                       'TPLVAR_HAS_RECUR'      => $hasRecur ) ) );

        $btn = array( );
        $btn['saveEvent'] = array( 'text' => $this->EventRes->getContents('LANG_SAVE_EVENT') );
        if( $info['eventID'] > 0 ) {
            $btn['deleteEvent'] = array( 'class' => 'delete',
                                         'text'  => $this->EventRes->getContents('LANG_DELETE_EVENT') );
        }

        $this->View->setStyle( array( 'jquery' => 'editor',
                                      'markaxis/calendar' => 'event' ) );

        $this->View->setJScript( array( 'jquery.ui.editor' => 'jquery/jquery.editor.js',
                                        'markaxis.event'   => 'markaxis/calendar/markaxis.event.js' ) );
        $this->View->setButtons( $btn );
        return $this->View->render( 'markaxis/calendar/html/eventForm.tpl', $vars );
    }


    /**
    * Render File List
    * @return string
    */
    public function getFileList( $list ) {
        $tpl = '';
        if( is_array( $list ) && sizeof( $list ) > 0 ) {
            foreach( $list as $value ) {
                $ext = strtolower( array_pop( explode( '.', $value['filename'] ) ) );
                if( $ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif' ) {
                    $ext = 'image';
                }
                $vars = array( 'TPLVAR_FILE_ID'   => $value['attachID'],
                               'TPLVAR_FILENAME'  => $value['filename'],
                               'TPLVAR_FILESIZE'  => File::formatBytes( $value['filesize'] ),
                               'TPLVAR_FILETYPE'  => $ext,
                               'LANG_DELETE_FILE' => $this->EventRes->getContents('LANG_DELETE_FILE') );
                $tpl .= $this->View->render( 'markaxis/calendar/html/fileList.tpl', $vars );
            }
        }
        return $tpl;
    }


    /**
    * Render Calendar Table
    * @return string
    */
    public function renderLabelForm( ) {
        $labels = $this->CalendarModel->getLabels( );
        $vars = array( );
        if( sizeof( $labels ) > 0 ) {
            foreach( $labels as $labelID => $row ) {
                $vars['dynamic']['label'][] = array( 'TPLVAR_LABEL_ID' => $labelID,
                                                     'TPLVAR_COLOR'    => $row['color'],
                                                     'TPLVAR_LABEL'    => $row['label'] );
            }
        }
        else {
            $vars['dynamic']['label'] = false;
        }

        $btn = array( );
        $btn['done'] = array( 'text' => $this->EventRes->getContents('LANG_IM_DONE') );
        $this->View->setJScript( array( 'jquery.ui.core'     => 'jquery/jquery.ui.core.js',
                                        'jquery.ui.sortable' => 'jquery/jquery.ui.sortable.js',
                                        'markaxis.label'     => 'markaxis/calendar/markaxis.label.js' ) );

        $this->View->setTitle( $this->EventRes->getContents('LANG_MANAGE_LABELS') );
        $this->View->setStyle( array( 'markaxis/calendar' => 'event' ) );
        $this->View->setButtons( $btn );
        return $this->View->render( 'markaxis/calendar/html/label.tpl', $vars );
    }


    /**
    * Render Calendar Table
    * @return string
    */
    public function renderEventDeleted( ) {
        $vars = array( 'LANG_MSG' => $this->EventRes->getContents('LANG_EVENT_NOT_FOUND_MSG') );
        $this->View->setTitle( $this->EventRes->getContents('LANG_EVENT_NOT_FOUND') );
        $this->View->setStyle( array( 'markaxis/calendar' => 'event' ) );
        return $this->View->render( 'markaxis/calendar/html/prompt.tpl', $vars );
    }
}
?>