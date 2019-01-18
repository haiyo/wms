<?php
namespace Markaxis\Calendar;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CalendarMapControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarMapControl {


    // Properties


    /**
    * CalendarMapControl Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * Map Form View
    * @return void
    */
    public function newEvent( ) {
        $CalendarMapModel = CalendarMapModel::getInstance( );
        $CalendarMapView = new CalendarMapView( $CalendarMapModel );
        Control::setOutputArrayAppend( array( 'tab'  => $CalendarMapView->renderTab( ),
                                              'data' => $CalendarMapView->renderData( ) ) );
    }


    /**
    * Map Form View
    * @return void
    */
    public function editEvent( ) {
        $CalendarMapModel = CalendarMapModel::getInstance( );
        $CalendarMapView = new CalendarMapView( $CalendarMapModel );
        Control::setOutputArrayAppend( array( 'tab'  => $CalendarMapView->renderTab( ),
                                              'data' => $CalendarMapView->renderData( ) ) );
    }


    /**
    * Get a single event
    * @return void
    */
    public function getEvent( ) {
        $CalendarModel = CalendarModel::getInstance( );
        $eventInfo = $CalendarModel->getInfo( );

        if( $eventInfo['eventID'] > 0 && $eventInfo['address'] ) {
            $CalendarMapModel = CalendarMapModel::getInstance( );
            $CalendarMapView = new CalendarMapView( $CalendarMapModel );
            $vars = array( );
            $vars['tab']     = $CalendarMapView->renderAgendaTab( );
            $vars['tabData'] = $CalendarMapView->renderAgendaData( $eventInfo );
            Control::setOutputArrayAppend( $vars );
        }
    }


    /**
    * Iterate through events and insert address if needed
    * @return void
    
    public function getEvents( ) {
        File::import( MODEL . 'Markaxis/Calendar/CalendarMapModel.class.php' );
        $CalendarMapModel = CalendarMapModel::getInstance( );
        Control::setOutputArray( $CalendarMapModel->iterateAddress( Control::getOutputArray( ) ) );
    }*/


    /**
    * Iterate through events and insert address if needed
    * @return void
    
    public function getRecurs( ) {
        File::import( MODEL . 'Markaxis/Calendar/CalendarMapModel.class.php' );
        $CalendarMapModel = CalendarMapModel::getInstance( );
        Control::setOutputArray( $CalendarMapModel->iterateRecurAddress( Control::getOutputArray( ) ) );
    }*/


    /**
    * Save Event
    * @return void
    */
    public function saveEvent( ) {
        $CalendarMapModel = CalendarMapModel::getInstance( );
        if( $CalendarMapModel->validate( ) ) {
            $CalendarMapModel->save( );
            $info = $CalendarMapModel->getInfo( );
            $data = Control::getOutputArray( );
            $data['map'] = $info['address'];
            Control::setOutputArray( $data );
        }
    }
}
?>