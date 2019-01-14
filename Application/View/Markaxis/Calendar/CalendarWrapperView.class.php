<?php
namespace Markaxis\Calendar;
use \Registry, Aurora\LightboxView;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, July 7th, 2012
 * @version $Id: CalendarWrapperView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarWrapperView {


    // Properties
    protected $Registry;
    protected $View;
    protected $CalendarRes;
    protected $EventRes;


    /**
    * CalendarView Constructor
    * @return void
    */
    function __construct( ) {
        $this->Registry = Registry::getInstance( );
        $this->View = LightboxView::getInstance( );

        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->CalendarRes = $i18n->loadLanguage('Aurora/Helper/CalendarRes');
        $this->EventRes    = $i18n->loadLanguage('Markaxis/Calendar/EventRes');
	}


    /**
    * Render Event Form
    * @return str
    */
    public function renderWrapperForm( $calID, $tab, $data ) {
        $vars = array_merge( $this->EventRes->getContents( ),
                array( 'TPL_TAB'  => $tab,
                       'TPL_DATA' => $data,
                       'TPLVAR_CAL_ID' => $calID ) );

        $CalendarModel = CalendarModel::getInstance( );
        $data  = $CalendarModel->getInfo('data');
        $title = $data['eventID'] ? $this->EventRes->getContents('LANG_EDIT_EVENT') :
                                    $this->EventRes->getContents('LANG_CREATE_NEW_EVENT');

        $btn = array( );
        $btn['saveEvent'] = array( 'text' => $this->EventRes->getContents('LANG_SAVE_EVENT') );
        $this->View->setTitle( $title );
        $this->View->setButtons( $btn );
        $this->View->setStyle( array( 'jquery' => 'datepicker' ) );
        $this->View->setJScript( array( 'jquery.datepicker' => 'jquery/jquery.datepicker.js' ) );
        return $this->View->render( 'markaxis/calendar/html/wrapperForm.tpl', $vars );
    }


    /**
    * Render Event Form
    * @return str
    */
    public function renderAgendaWrapper( $date, $outputArray ) {
        $CalendarModel = CalendarModel::getInstance( );
        $eventInfo = $CalendarModel->getInfo( );
        // Use the click start date for output as it is the correct display target in the event of recurring
        $toTime = strtotime( $date[1] );//strtotime( $eventInfo['start'] );
        $today  = date( 'Y-m-d' );
        $day    = date( 'Y-m-d', $toTime ) != $today ? date( 'l', $toTime ) : $this->CalendarRes->getContents('LANG_TODAY');

        $vars = array_merge( $this->EventRes->getContents( ),
                array( 'TPLVAR_CAL_ID'    => $eventInfo['calID'],
                       'TPLVAR_EVENT_ID'  => $eventInfo['eventID'],
                       'TPLVAR_DAY_DATE'  => date( 'j', $toTime ),
                       'TPLVAR_DAY'       => $day,
                       'TPLVAR_MONTH'     => date( 'F', $toTime ),
                       'TPLVAR_CLASSNAME' => $eventInfo['className'],
                       'TPL_DATA'         => $outputArray['data'],
                       'TPL_TAB'          => isset( $outputArray['tab'] ) ? $outputArray['tab'] : '',
                       'TPL_TAB_DATA'     => isset( $outputArray['tabData'] ) ? $outputArray['tabData'] : '' ) );

        $vars['dynamic']['data'] = false;
        if( $outputArray['tabData'] ) {
            $vars['dynamic']['data'][] = true;
        }

        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        $btn = array( );
        $Authorization = $this->Registry->get( HKEY_CLASS, 'Authorization' );
        if( $Authorization->isAdmin( ) || $userInfo['userID'] == $eventInfo['userID'] ) {
            $btn['edit'] = array( 'text'  => $this->EventRes->getContents('LANG_EDIT_EVENT') );
            $btn['export'] = array( 'text' => $this->EventRes->getContents('LANG_EXPORT') );
            $btn['deleteEvent'] = array( 'class' => 'delete', 'text'  => $this->EventRes->getContents('LANG_DELETE_EVENT') );
        }
        else {
            $btn['export'] = array( 'text' => $this->EventRes->getContents('LANG_EXPORT') );
        }
        $this->View->setButtons( $btn );
        
        $this->View->setTitle( $this->EventRes->getContents('LANG_AGENDA') );
        $this->View->setStyle( array( 'markaxis/calendar' => 'agendaWrapper' ) );
        return $this->View->render( 'markaxis/calendar/html/agendaWrapper.tpl', $vars );
    }
}
?>