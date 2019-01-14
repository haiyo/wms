<?php
namespace Markaxis\Calendar;
use \Library\Runtime\Registry, Aurora\LightboxView;
use \Library\IO\File;
use \MXString;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CalendarMapView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarMapView {


    // Properties
    protected $Registry;
    protected $HKEY_LOCAL;
    protected $View;
    protected $L10n;
    protected $CalendarMapModel;


    /**
    * CalendarMapView Constructor
    * @return void
    */
    function __construct( CalendarMapModel $CalendarMapModel ) {
        $this->Registry = Registry::getInstance( );
        $this->View = LightboxView::getInstance( );

        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Calendar/MapRes');
        $this->CalendarMapModel = $CalendarMapModel;

        $this->View->setJScript( array( 'markaxis.map.i18n' => 'locale/' . $this->L10n->getL10n( ) ) );
	}


    /**
    * Render Tab
    * @return str
    */
    public function renderTab( ) {
        $vars = array( 'TPVAR_TAB_ID' => 'map',
                       'LANG_TITLE'   => $this->L10n->getContents('LANG_MAP_LOCATION') );

        return $this->View->render( 'markaxis/calendar/html/tab.tpl', $vars );
    }


    /**
    * Return map form
    * @return str
    */
    public function renderData( ) {
        $CalendarModel = CalendarModel::getInstance( );
        $data    = $CalendarModel->getInfo('data');
        $address = isset( $data['address'] ) ? $data['address'] : '';

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_ADDRESS'       => $address,
                       'TPLVAR_ENTER_ADDRESS' => $address ) );

        $this->View->setJScript( array( 'markaxis.map' => 'markaxis/calendar/markaxis.map.js' ) );
        return $this->View->render( 'markaxis/calendar/html/mapForm.tpl', $vars );
    }


    /**
    * Render Agenda Tab
    * @return str
    */
    public function renderAgendaTab( ) {
        $vars = array( 'TPVAR_TAB_ID' => 'agendaMap',
                       'LANG_TITLE'   => $this->L10n->getContents('LANG_MAP_LOCATION') );

        return $this->View->render( 'markaxis/calendar/html/tab.tpl', $vars );
    }


    /**
    * Render Agenda
    * @return str
    */
    public function renderAgendaData( $eventInfo ) {
        $vars = array( 'TPLVAR_ADDRESS' => $eventInfo['eAddress'] );

        $this->View->setStyle( array( 'markaxis/calendar' => 'agendaMap' ) );
        $this->View->setJScript( array( 'markaxis.map' => 'markaxis/calendar/markaxis.map.js' ) );
        return $this->View->render( 'markaxis/calendar/html/agendaMap.tpl', $vars );
    }
}
?>