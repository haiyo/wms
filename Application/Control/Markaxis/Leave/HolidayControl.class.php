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

        if( $eventInfo = $this->HolidayModel->getEvents( $post ) ) {
            Control::setOutputArrayAppend( array( 'events' => $eventInfo ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function addType( ) {
        $output = Control::getOutputArray( );
        $this->LeaveView->renderTypeForm( $output['form'] );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function editType( $args ) {
        $output = Control::getOutputArray( );
        $ltID = isset( $args[1] ) ? (int)$args[1] : 0;

        $this->LeaveView->renderTypeForm( $output['form'], $ltID );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveType( ) {;
        $post = Control::getPostData( );
        echo json_encode( $post );
        exit;
    }
}
?>