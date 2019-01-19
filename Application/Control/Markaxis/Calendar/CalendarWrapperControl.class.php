<?php
namespace Markaxis\Calendar;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CalendarWrapperControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarWrapperControl {


    // Properties


    /**
    * CalendarWrapperControl Constructor
    * @return void
    */
    function __construct( ) {
        //
	}

    /**
    * Show Event Form
    * @return void
    */
    public function newEvent( $param ) {
        $output = Control::getOutputArray( );
        $tab    = isset( $output['tab']  ) ? $output['tab'] : '';
        $data   = isset( $output['data'] ) ? $output['data'] : '';

        $CalendarWrapperView = new CalendarWrapperView( );

        if( isset( $param[1] ) ) { // track calID and "permission"!
            $output = $CalendarWrapperView->renderWrapperForm( $param[1], $tab, $data );
        }
        $LightboxView = LightboxView::getInstance( );
        $LightboxView->printAll( $output );
    }


    /**
    * Show Event Form
    * @return void
    */
    public function editEvent( $param ) {
        $output = Control::getOutputArray( );
        $tab    = isset( $output['tab']  ) ? $output['tab'] : '';
        $data   = isset( $output['data'] ) ? $output['data'] : '';

        $CalendarWrapperView = new CalendarWrapperView( );

        if( isset( $param[1] ) ) { // track eventID and "permission"!
            $output = $CalendarWrapperView->renderWrapperForm( $param[1], $tab, $data );
        }
        $LightboxView = LightboxView::getInstance( );
        $LightboxView->printAll( $output );
    }


    /**
    * Get a single event
    * @return void
    */
    public function getEvent( $param ) {
        if( isset( $param[2] ) && isset( $param[3] ) ) {
            $date = array( );
            $date[1] = $param[2];
            $date[2] = $param[3];

            $CalendarWrapperView = new CalendarWrapperView( );
            $LightboxView = LightboxView::getInstance( );
            $LightboxView->printAll( $CalendarWrapperView->renderAgendaWrapper( $date, Control::getOutputArray( ) ) );
        }
    }


    /**
    * Get Events
    * @return void
    */
    public function getEvents( ) {
        echo json_encode( Control::getOutputArray( ) );
        exit;
    }


    /**
    * Get Recurring Events
    * @return void
    */
    public function getRecurs( ) {
        echo json_encode( Control::getOutputArray( ) );
        exit;
    }


    /**
    * Save Event
    * @return void
    */
    public function saveEvent( ) {
        echo json_encode( Control::getOutputArray( ) );
        exit;
    }
}
?>