<?php
namespace Markaxis\Leave;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: HolidayControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class HolidayControl {


    // Properties
    private $HolidayModel;
    private $HolidayView;


    /**
     * HolidayControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->HolidayModel = HolidayModel::getInstance( );
        $this->HolidayView = new HolidayView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function settings( ) {
        Control::setOutputArrayAppend( array( 'form' => $this->HolidayView->renderSettings( ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getHoliday( $data ) {
        if( isset( $data[1] ) ) {
            $vars = array( );
            $vars['data'] = $this->HolidayModel->getByhID( $data[1] );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getHolidayResults( ) {
        $post = Control::getRequest( )->request( POST );
        echo json_encode( $this->HolidayModel->getResults( $post ) );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getEvents( ) {
        $post = Control::getRequest( )->request( POST );

        if( isset( $post['type'] ) && $post['type'] == 'holiday' ) {
            if( $eventInfo = $this->HolidayModel->getEvents( $post ) ) {
                Control::setOutputArrayAppend( array( 'events' => $eventInfo ) );
            }
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveHoliday( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );
        $vars = array( );
        $vars['bool'] = 0;

        if( $this->HolidayModel->saveHoliday( $post ) ) {
            $vars['bool'] = 1;
        }
        else {
            $vars['errMsg'] = $this->HolidayModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deleteHoliday( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );
        $vars['bool'] = 0;

        if( $this->HolidayModel->deleteHoliday( $post ) ) {
            $vars['bool'] = 1;
        }
        else {
            $vars['errMsg'] = $this->HolidayModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }
}
?>