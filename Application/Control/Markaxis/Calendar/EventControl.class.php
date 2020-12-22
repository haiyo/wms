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
    * Get a single event
    * @return void
    */
    public function getEvents( ) {
        $post = Control::getRequest( )->request( POST );

        if( isset( $post['user'] ) && $eventInfo = $this->EventModel->getEvents( $post ) ) {
            Control::setOutputArrayAppend( array( 'events' => $eventInfo ) );
        }
    }


    /**
    * Get all recurring events
    * @return void
    */
    public function getRecurs( ) {
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
        $vars['bool'] = 1;
        $this->EventModel->deleteEvent( $post );
        echo json_encode( $vars );
        exit;
    }
}
?>