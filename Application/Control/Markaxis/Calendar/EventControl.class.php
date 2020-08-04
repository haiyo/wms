<?php
namespace Markaxis\Calendar;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: EventControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EventControl {


    // Properties
    protected $EventModel;
    protected $EventView;


    /**
    * CalendarControl Constructor
    * @return void
    */
    function __construct( ) {
        $this->EventModel = EventModel::getInstance( );
        $this->EventView = new EventView( );
	}


    /**
     * Render main navigation
     * @return string
     */
    public function dashboard( ) {
        Control::setOutputArrayAppend( array( 'sidebarCards' => $this->EventView->renderUpcomingEvents( ) ) );
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
        $post = Control::getRequest( )->request( POST );

        if( $eventInfo = $this->EventModel->getEvents( $post ) ) {
            Control::setOutputArrayAppend( array( 'events' => $eventInfo ) );
        }
    }


    /**
    * Get all recurring events
    * @return void
    */
    public function getRecurs( ) {
        $post = Control::getRequest( )->request( POST );

        $post = Control::getRequest( )->request( POST );
        echo json_encode( $this->EventModel->getRecurs( $post ) );
        exit;
    }


    /**
    * Save Event
    * @return void
    */
    public function saveEvent( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );
        $vars = array( );
        $vars['bool'] = 0;

        if( !$this->EventModel->isValid( $post ) ) {
            $vars['errMsg'] = $this->EventModel->getErrMsg( );
        }
        else {
            if( $this->EventModel->save( ) ) {
                $info = $this->EventModel->getInfo( );
                $vars['bool'] = 1;
                $vars = array_merge( $vars, $info );
            }
            else $vars['errMsg'] = $this->EventModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Save Event
     * @return void
     */
    public function updateEventDropDrag( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );
        $vars = array( );
        $vars['bool'] = 0;

        if( $this->EventModel->updateEventDropDrag( $post ) ) {
            $vars['bool'] = 1;
        }
        else $vars['errMsg'] = $this->EventModel->getErrMsg( );

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