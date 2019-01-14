<?php
namespace Markaxis\Calendar;
use \Library\IO\File;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CalendarRSVPControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarRSVPControl {


    // Properties


    /**
    * CalendarRSVPControl Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * Get Notification
    * @return str
    */
    public function getNotification( $info ) {
        File::import( MODEL . 'Markaxis/Calendar/CalendarRSVPModel.class.php' );
        $CalendarRSVPModel = CalendarRSVPModel::getInstance( );

        File::import( VIEW . 'Aurora/AuroraView.class.php' );
        File::import( VIEW . 'Aurora/LightboxView.class.php' );
        File::import( VIEW . 'Markaxis/Calendar/CalendarRSVPView.class.php' );
        $CalendarRSVPView = new CalendarRSVPView( $CalendarRSVPModel );
        return $CalendarRSVPView->getNotification( $info );
    }


    /**
    * Get a single event
    * @return void
    */
    public function getEvent( ) {
        $CalendarModel = CalendarModel::getInstance( );
        $eventInfo = $CalendarModel->getInfo( );

        if( $eventInfo['eventID'] > 0 && $eventInfo['rsvp'] ) {
            File::import( MODEL . 'Markaxis/Calendar/CalendarRSVPModel.class.php' );
            $CalendarRSVPModel = CalendarRSVPModel::getInstance( );

            File::import( VIEW . 'Aurora/AuroraView.class.php' );
            File::import( VIEW . 'Aurora/LightboxView.class.php' );
            File::import( VIEW . 'Markaxis/Calendar/CalendarRSVPView.class.php' );
            $CalendarRSVPView = new CalendarRSVPView( $CalendarRSVPModel );
            $vars = array( );
            $vars['tab']     = $CalendarRSVPView->renderAgendaTab( );
            $vars['tabData'] = $CalendarRSVPView->renderAgendaData( $eventInfo );
            Control::setOutputArrayAppend( $vars );
        }
    }


    /**
    * Connection Form View
    * @return void
    */
    public function newEvent( ) {
        File::import( MODEL . 'Markaxis/Calendar/CalendarRSVPModel.class.php' );
        $CalendarRSVPModel = CalendarRSVPModel::getInstance( );

        File::import( VIEW . 'Aurora/AuroraView.class.php' );
        File::import( VIEW . 'Aurora/LightboxView.class.php' );
        File::import( VIEW . 'Markaxis/Calendar/CalendarRSVPView.class.php' );
        $CalendarRSVPView = new CalendarRSVPView( $CalendarRSVPModel );
        Control::setOutputArrayAppend( array( 'tab'  => $CalendarRSVPView->renderTab( ),
                                              'data' => $CalendarRSVPView->renderForm( ) ) );
    }


    /**
    * Connection Form View
    * @return void
    */
    public function editEvent( ) {
        File::import( MODEL . 'Markaxis/Calendar/CalendarRSVPModel.class.php' );
        $CalendarRSVPModel = CalendarRSVPModel::getInstance( );

        File::import( VIEW . 'Aurora/AuroraView.class.php' );
        File::import( VIEW . 'Aurora/LightboxView.class.php' );
        File::import( VIEW . 'Markaxis/Calendar/CalendarRSVPView.class.php' );
        $CalendarRSVPView = new CalendarRSVPView( $CalendarRSVPModel );
        Control::setOutputArrayAppend( array( 'tab'  => $CalendarRSVPView->renderTab( ),
                                              'data' => $CalendarRSVPView->renderForm( ) ) );
    }


    /**
    * Save Event
    * @return void
    */
    public function saveEvent( ) {
        File::import( MODEL . 'Markaxis/Calendar/CalendarRSVPModel.class.php' );
        $CalendarRSVPModel = new CalendarRSVPModel( );
        if( $CalendarRSVPModel->validate( ) ) {
            $CalendarRSVPModel->save( );
            $data = Control::getOutputArray('data');
            $data['rsvp'] = 1;
            Control::setOutputArray( $data );
        }
    }


    /**
    * AJAX call for role list
    * @return void
    */
    public function getRoles( ) {
        File::import( MODEL . 'Markaxis/Calendar/CalendarRSVPModel.class.php' );
        $CalendarRSVPModel = CalendarRSVPModel::getInstance( );

        File::import( VIEW . 'Aurora/AuroraView.class.php' );
        File::import( VIEW . 'Aurora/LightboxView.class.php' );
        File::import( VIEW . 'Markaxis/Calendar/CalendarRSVPView.class.php' );
        $CalendarRSVPView = new CalendarRSVPView( $CalendarRSVPModel );
        $vars = array( );
        $vars['bool'] = 1;
        $vars['html'] = $CalendarRSVPView->renderRoles( );
        echo json_encode( $vars );
        exit;
    }


    /**
    * AJAX call for user list
    * @return void
    */
    public function getUsers( ) {
        $post = Control::getRequest( )->request( POST );

        File::import( MODEL . 'Markaxis/Calendar/CalendarRSVPModel.class.php' );
        $CalendarRSVPModel = CalendarRSVPModel::getInstance( );

        File::import( VIEW . 'Aurora/AuroraView.class.php' );
        File::import( VIEW . 'Aurora/LightboxView.class.php' );
        File::import( VIEW . 'Markaxis/Calendar/CalendarRSVPView.class.php' );
        $CalendarRSVPView = new CalendarRSVPView( $CalendarRSVPModel );
        echo json_encode( $CalendarRSVPView->renderUserList( $post ) );
        exit;
    }


    /**
    * Update Attendance
    * @return void
    */
    public function updateAttendance( ) {
        $post = Control::getRequest( )->request( POST );

        if( isset( $post['eventID'] ) && isset( $post['attending'] ) ) {
            File::import( MODEL . 'Markaxis/Calendar/CalendarRSVPModel.class.php' );
            $CalendarRSVPModel = CalendarRSVPModel::getInstance( );
            echo json_encode( $CalendarRSVPModel->update( $post['eventID'], $post['attending'] ) );
            exit;
        }
    }


    /**
    * Grab URL content
    * @return void
    */
    public function grabURL( ) {
        File::import( CONTROL . 'Markaxis/Feed/FeedControl.class.php' );
        $FeedControl = new FeedControl( 'markaxis_rsvp_feed', 'markaxis_rsvp_comment' );
        $FeedControl->grabURL( );
    }


    /**
    * Post main feed
    * @return void
    */
    public function post( ) {
        $post = Control::getRequest( )->request( POST );

        if( isset( $post['eventID'] ) ) {
            $vars = array( );
            $vars['bool'] = 0;
            File::import( MODEL . 'Markaxis/Calendar/CalendarRSVPModel.class.php' );
            $CalendarRSVPModel = CalendarRSVPModel::getInstance( );

            File::import( MODEL . 'Markaxis/Feed/FeedModel.class.php' );
            $FeedModel = new FeedModel( );

            if( $FeedModel->setInfo( $post ) && $CalendarRSVPModel->setInfo( $post ) ) {
                $FeedModel->setTable( 'markaxis_rsvp_feed' );
                if( $info = $FeedModel->save( ) ) {
                    File::import( VIEW . 'Aurora/AuroraView.class.php' );
                    File::import( VIEW . 'Aurora/LightboxView.class.php' );
                    File::import( VIEW . 'Markaxis/Feed/FeedView.class.php' );
                    $FeedView = new FeedView( $FeedModel );
                    if( !isset( $post['parentID'] ) ) {
                        $vars['html'] = $FeedView->renderFeedList( $info );
                    }
                    else {
                        $vars['html'] = $FeedView->renderCommentList( $info );
                    }
                    $vars['bool'] = 1;
                }
            }
            echo json_encode( $vars );
            exit;
        }
    }


    /**
    * Get Embed Code
    * @return void
    */
    public function getEmbedCode( ) {
        $post = Control::getRequest( )->request( POST, 'link' );

        File::import( MODEL . 'Markaxis/Feed/FeedModel.class.php' );
        $FeedModel = new FeedModel( 'markaxis_rsvp_feed', 'markaxis_rsvp_comment' );
        $vars = array( );
        $vars['bool'] = 1;
        $vars['html'] = $FeedModel->getEmbedCode( $post );
        echo json_encode( $vars );
        exit;
    }
}
?>