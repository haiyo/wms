<?php
namespace Markaxis\Calendar;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CalendarControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarControl {


    // Properties
    protected $CalendarModel;
    protected $CalendarView;


    /**
    * CalendarControl Constructor
    * @return void
    */
    function __construct( ) {
        $this->CalendarModel = CalendarModel::getInstance( );
        $this->CalendarView = new CalendarView( );
	}


    /**
     * Render main navigation
     * @return string
     */
    public function dashboard( ) {
        Control::setOutputArrayAppend( array( 'sidebarCards' => $this->CalendarView->renderUpcomingEvents( ) ) );
    }


    /**
    * Show Calendar
    * @return void
    */
    public function calendar( ) {
        $date = getdate( time( ) );

        //echo json_encode( $CalendarView->renderCalendar( $date ) );
        $this->CalendarView->printAll( $this->CalendarView->renderCalendar( $date ) );
	}


    /**
    * Remove Calendar
    * @return void
    */
    public function remove( ) {
        // so far nothing to do
	}


    /**
    * Show the list of events
    * @return void
    */
    public function readEvents( $param ) {
        $CalendarModel = CalendarModel::getInstance( );
        $CalendarView = new CalendarView( $CalendarModel );
        $output = $CalendarView->renderEventList( $param );

        $LightboxView = LightboxView::getInstance( );
        $LightboxView->printAll( $output );
    }


    /**
    * Show Event Form
    * @return void
    */
    public function newEvent( $param ) {
        $CalendarModel = CalendarModel::getInstance( );
        $CalendarModel->setNewEventInfo( $param );

        $CalendarView = new CalendarView( $CalendarModel );
        Control::setOutputArrayAppend( array( 'tab'  => $CalendarView->renderFormTab( ),
                                              'data' => $CalendarView->renderEventForm( ) ) );
    }


    /**
    * Show Event Form
    * @return void
    */
    public function editEvent( $param ) {
        $eventID = (int)$param[2];

        $CalendarModel = CalendarModel::getInstance( );
        $CalendarView = new CalendarView( $CalendarModel );

        if( $CalendarModel->loadEvent( $eventID ) ) {
            Control::setOutputArrayAppend( array( 'tab'  => $CalendarView->renderFormTab( ),
                                                  'data' => $CalendarView->renderEventForm( ) ) );
        }
        else {
            $output = $CalendarView->renderEventDeleted( );
            $LightboxView = LightboxView::getInstance( );
            $LightboxView->printAll( $output );
            exit;
        }
    }


    /**
    * Get a single event
    * @return void
    */
    public function getEvents( ) {
        $data = Control::getOutputArray( );
        $vars = array( );

        if( isset( $data['events'] ) ) {
            echo json_encode( $data['events'] );
            exit;
            //$this->CalendarModel
        }
    }


    /**
    * Get all recurring events
    * @return void
    */
    public function getRecurs( ) {
        $vars = array( );
        $vars['bool'] = 0;
        $post = Control::getRequest( )->request( POST );

        $CalendarModel = CalendarModel::getInstance( );
        $info = $CalendarModel->getRecurs( $post );

        if( sizeof( $info ) > 0 ) {
            $vars['bool'] = 1;
            $vars['data'] = $info;
        }
        Control::setOutputArray( $vars );
    }


    /**
    * Save Event
    * @return void
    */
    public function saveEvent( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );
        $vars['bool'] = 0;

        $CalendarModel = CalendarModel::getInstance( );
        if( !$CalendarModel->validate( $post ) ) {
            $vars['errMsg'] = $CalendarModel->getErrMsg( );
        }
        else {
            if( $CalendarModel->save( ) ) {
                $info = $CalendarModel->getInfo( );
                $vars['bool'] = 1;
                $vars = array_merge( $vars, $info );
            }
            else $vars['errMsg'] = $CalendarModel->getErrMsg( );
        }
        Control::setOutputArray( $vars );
    }


    /**
    * Update an event on drag
    * @return void
    */
    public function updateEventDrag( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );
        $vars['bool'] = 0;

        $CalendarModel = CalendarModel::getInstance( );
        if( !$CalendarModel->updateEventDrag( $post ) ) {
            $vars['errMsg'] = $CalendarModel->getErrMsg( );
        }
        else {
            $vars['bool'] = 1;
        }
        echo json_encode( $vars );
        exit;
    }


    /**
    * Delete an event
    * @return void
    */
    public function deleteEvent( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );
        $vars['bool'] = 0;

        $CalendarModel = CalendarModel::getInstance( );
        if( !$CalendarModel->deleteEvent( $post ) ) {
            $vars['errMsg'] = $CalendarModel->getErrMsg( );
        }
        else {
            $vars['bool'] = 1;
        }
        echo json_encode( $vars );
        exit;
    }


    /**
    * Show Label List Form
    * @return void
    */
    public function label( ) {
        $CalendarModel = CalendarModel::getInstance( );
        $CalendarView = new CalendarView( $CalendarModel );
        $output = $CalendarView->renderLabelForm( );

        $LightboxView = LightboxView::getInstance( );
        $LightboxView->printAll( $output );
    }


    /**
    * Save Label
    * @return void
    */
    public function saveLabel( ) {
        $post   = Control::getRequest( )->request( POST );
        $data   = explode( '&', $post['data'] );
        $sizeOf = sizeof( $data );

        $CalendarModel = CalendarModel::getInstance( );

        for( $i=0; $i<$sizeOf; $i++ ) {
            preg_match( '/element(\d+)=(.*)/', $data[$i], $match );
            $CalendarModel->saveLabel( $match[1], urldecode( $match[2] ), ($i+1) );
        }
        echo 1;
        exit;
    }


    /**
    * Save Event
    * @return void
    */
    public function setApproval( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );
        $vars['bool'] = 0;

        $CalendarModel = CalendarModel::getInstance( );
        $CalendarModel->addObservers( new CalendarMessageModel( ) );

        if( !$CalendarModel->setApproval( $post ) ) {
            $vars['errMsg'] = $CalendarModel->getErrMsg( );
        }
        else {
            $CalendarModel->notifyObservers('setApproval');
            $vars['bool'] = 1;
            $vars = array_merge( $vars, $CalendarModel->getInfo( ) );
        }
        echo json_encode( $vars );
        exit;
    }
}
?>