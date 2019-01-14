<?php
namespace Markaxis\Calendar;
use \Library\IO\File;
use \Control;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CalendarControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarControl {


    // Properties
    protected $CalendarView;


    /**
    * CalendarControl Constructor
    * @return void
    */
    function __construct( ) {
        File::import( VIEW . 'Markaxis/Calendar/CalendarView.class.php' );
        $this->CalendarView = new CalendarView( );
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
        File::import( MODEL . 'Markaxis/Calendar/CalendarModel.class.php' );
        $CalendarModel = CalendarModel::getInstance( );

        File::import( VIEW . 'Aurora/AuroraView.class.php' );
        File::import( VIEW . 'Aurora/LightboxView.class.php' );
        File::import( VIEW . 'Markaxis/Calendar/CalendarView.class.php' );
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
        File::import( MODEL . 'Markaxis/Calendar/CalendarModel.class.php' );
        $CalendarModel = CalendarModel::getInstance( );
        $CalendarModel->setNewEventInfo( $param );

        File::import( VIEW . 'Aurora/AuroraView.class.php' );
        File::import( VIEW . 'Aurora/LightboxView.class.php' );
        File::import( VIEW . 'Markaxis/Calendar/CalendarView.class.php' );
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

        File::import( MODEL . 'Markaxis/Calendar/CalendarModel.class.php' );
        $CalendarModel = CalendarModel::getInstance( );

        File::import( VIEW . 'Aurora/AuroraView.class.php' );
        File::import( VIEW . 'Aurora/LightboxView.class.php' );
        File::import( VIEW . 'Markaxis/Calendar/CalendarView.class.php' );
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
    public function getEvent( $param ) {
        if( isset( $param[1] ) ) {
            $vars = array( );
            File::import( MODEL . 'Markaxis/Calendar/CalendarModel.class.php' );
            $CalendarModel = CalendarModel::getInstance( );

            File::import( VIEW . 'Aurora/AuroraView.class.php' );
            File::import( VIEW . 'Aurora/LightboxView.class.php' );
            File::import( VIEW . 'Markaxis/Calendar/CalendarView.class.php' );
            $CalendarView = new CalendarView( $CalendarModel );

            if( $CalendarModel->loadEvent( $param[1]/*, $param[2], $param[3]*/ ) ) {
                $vars['tab']     = $CalendarView->renderAgendaTab( );
                $vars['tabData'] = $CalendarView->renderAgendaTabData( );
                $vars['data']    = $CalendarView->renderAgenda( );
            }
            else {
                // Someone might have deleted the event at the same time.
                $LightboxView = LightboxView::getInstance( );
                $LightboxView->printAll( $CalendarView->renderEventDeleted( ) );
                exit;
            }
            Control::setOutputArray( $vars );
        }
    }


    /**
    * Get all events
    * @return void
    */
    public function getEvents( ) {
        File::import( MODEL . 'Markaxis/Calendar/CalendarModel.class.php' );
        $CalendarModel = CalendarModel::getInstance( );
        Control::setOutputArray( $CalendarModel->getEvents( Control::getRequest( )->request( POST ) ) );
    }


    /**
    * Get all recurring events
    * @return void
    */
    public function getRecurs( ) {
        $vars = array( );
        $vars['bool'] = 0;
        $post = Control::getRequest( )->request( POST );

        File::import( MODEL . 'Markaxis/Calendar/CalendarModel.class.php' );
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

        File::import( MODEL . 'Markaxis/Calendar/CalendarModel.class.php' );
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

        File::import( MODEL . 'Markaxis/Calendar/CalendarModel.class.php' );
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

        File::import( MODEL . 'Markaxis/Calendar/CalendarModel.class.php' );
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
        File::import( MODEL . 'Markaxis/Calendar/CalendarModel.class.php' );
        $CalendarModel = CalendarModel::getInstance( );

        File::import( VIEW . 'Aurora/AuroraView.class.php' );
        File::import( VIEW . 'Aurora/LightboxView.class.php' );
        File::import( VIEW . 'Markaxis/Calendar/CalendarView.class.php' );
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

        File::import( MODEL . 'Markaxis/Calendar/CalendarModel.class.php' );
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

        File::import( MODEL . 'Markaxis/Calendar/CalendarMessageModel.class.php' );
        File::import( MODEL . 'Markaxis/Calendar/CalendarModel.class.php' );
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