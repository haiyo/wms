<?php
namespace Markaxis\Calendar;
use \Library\Helper\Markaxis\LabelHelper;
use \Library\Helper\Aurora\TimeHelper, \Aurora\Form\DayIntListView;
use \Library\Runtime\Registry, \Aurora\Admin\AdminView, \Aurora\Form\SelectListView, \Aurora\Form\CheckboxView;
use \Library\Helper\Markaxis\RecurHelper, \Library\Helper\Markaxis\ReminderHelper;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, July 7th, 2012
 * @version $Id: CalendarView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EventView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $EventRes;
    protected $EventModel;


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
        $this->EventRes = $i18n->loadLanguage('Markaxis/Calendar/EventRes');

        $this->EventModel = EventModel::getInstance( );
	}


    /**
     * Render Tab
     * @return string
     */
    public function renderUpcomingEvents( ) {
        $info = array( );
        $info['user']  = 'owner';
        $info['start'] = date('Y-m-d h:i:s');
        $info['end']   = date('Y-m-d h:i:s', strtotime($info['start']. ' +2 days') );
        $info['type']  = 'day';

        $currDateTime = time( );
        $eventList = $this->EventModel->getEvents( $info );

        $vars = array( );
        $vars['dynamic']['noEvent'] = true;
        $vars['dynamic']['event']   = false;

        if( sizeof( $eventList ) > 0 ) {
            $vars['dynamic']['noEvent'] = false;

            foreach( $eventList as $value ) {
                $time = strtotime( $value['end'] );

                if( $time > $currDateTime ) {
                    $timestamp  = date('jS F h:ia', strtotime( $value['start'] ) );
                    $timestamp .= ' - ';
                    $timestamp .= date('h:ia', $time );
                    $vars['dynamic']['event'][] = array( 'TPLVAR_DATE' => $timestamp,
                                                         'TPLVAR_TITLE' => $value['title'] );
                }
            }
        }

        $recurList = $this->EventModel->getRecurs( $info, true );

        if( sizeof( $recurList ) > 0 ) {
            $vars['dynamic']['noEvent'] = false;

            foreach( $recurList as $value ) {
                $time = strtotime( $value['end'] );

                if( $time > $currDateTime ) {
                    $timestamp  = date('D M jS h:ia', strtotime( $value['start'] ) );
                    $timestamp .= ' - ';
                    $timestamp .= date('h:ia', $time );

                    $vars['dynamic']['event'][] = array( 'TPLVAR_DATE' => $timestamp,
                                                         'TPLVAR_TITLE' => $value['title'] );
                }
            }
        }

        $vars = array_merge( $this->EventRes->getContents( ), $vars );

        return $this->View->render( 'markaxis/calendar/upcomingEvent.tpl', $vars );
    }
}
?>