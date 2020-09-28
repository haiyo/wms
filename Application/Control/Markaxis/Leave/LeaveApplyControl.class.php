<?php
namespace Markaxis\Leave;
use \Markaxis\Employee\EmployeeModel;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: LeaveApplyControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveApplyControl {


    // Properties
    private $LeaveApplyModel;
    private $LeaveApplyView;


    /**
     * LeaveApplyControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->LeaveApplyModel = new LeaveApplyModel( );
        $this->LeaveApplyView = new LeaveApplyView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function globalInit( ) {
        $EmployeeModel = EmployeeModel::getInstance( );
        $empInfo = $EmployeeModel->getInfo( );
        $data = Control::getOutputArray( );

        if( is_array( $empInfo ) && sizeof( $empInfo ) > 0 && isset( $data['leaveTypes'] ) && is_array( $data['leaveTypes'] ) &&
            sizeof( $data['leaveTypes'] ) > 0 ) {
            Control::setOutputArray( array( 'leaveTypes' => $this->LeaveApplyModel->getByUserLeaveTypeCurrYear( $empInfo['userID'], $data['leaveTypes'] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function dashboard( ) {
        Control::setOutputArrayAppend( $this->LeaveApplyView->renderApplyForm( ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function balance( ) {
        Control::setOutputArrayAppend( $this->LeaveApplyView->renderApplyForm( ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getHistory( ) {
        $post = Control::getRequest( )->request( POST );
        Control::setOutputArray( array( 'list' => $this->LeaveApplyModel->getHistory( $post ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getPendingAction( ) {
        Control::setOutputArrayAppend( array( 'pending' => $this->LeaveApplyView->renderPendingAction( ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getRequest( ) {
        if( $request = $this->LeaveApplyModel->getRequest( ) ) {
            Control::setOutputArrayAppend( array( 'leave' => $request ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getEvents( ) {
        $post = Control::getRequest( )->request( POST );

        if( isset( $post['user'] ) && $post['user'] == 'colleague' && $eventInfo = $this->LeaveApplyModel->getEvents( $post ) ) {
            Control::setOutputArrayAppend( array( 'events' => $eventInfo ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function apply( ) {
        $post = Control::getPostData( );
        $this->LeaveApplyModel->save( $post );
        Control::setPostData( array_merge( $post, $this->LeaveApplyModel->getInfo( ) ) );
    }


    /**
     * For No Pay Leave
     * @return string
     */
    public function cancel( ) {
        $post = Control::getRequest( )->request( POST );

        if( isset( $post['laID'] ) ) {
            $this->LeaveApplyModel->cancel( $post['laID'] );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( $this->LeaveApplyModel->processPayroll( $data ) );
    }


    /**
     * For No Pay Leave
     * @return string
     */
    public function savePayroll( $args ) {
        $data = Control::getOutputArray( );
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST ) );

        $this->processPayroll( $args );
        $this->LeaveApplyModel->savePayroll( $data, $post );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deletePayroll( ) {
        $data = Control::getOutputArray( );
        $this->LeaveApplyModel->deletePayroll( $data );
    }


    /**
     * Upload Attachment
     * @return void
     */
    public function upload( ) {
        // COR not enabled
        //header('Access-Control-Allow-Origin: *');
        header( 'Access-Control-Allow-Credentials: true' );
        header( 'Pragma: no-cache' );
        header( 'Cache-Control: no-store, no-cache, must-revalidate' );
        header( 'X-Content-Type-Options: nosniff' );
        header( 'Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size' );

        $vars = array( );
        $vars['bool'] = 0;
        $laID = Control::getRequest( )->request( POST, 'laID' );
        $file = Control::getRequest( )->request( FILES );

        if( $_SERVER['REQUEST_METHOD'] == 'POST' && empty( $_POST ) && empty( $_FILES ) &&
            $_SERVER['CONTENT_LENGTH'] > 0 ) {
            $vars['error'] = 'No files uploaded. Please make sure file size is within the allowed limit.';
        }
        else {
            if( $this->LeaveApplyModel->uploadSuccess( $laID, $file ) ) {
                $vars = $this->LeaveApplyModel->getFileInfo( );

                if( $vars['success'] == 2 ) {
                    unset( $vars['error'] );
                }
            }
            else {
                $vars['errMsg'] = $this->LeaveApplyModel->getErrMsg( );
            }
        }
        echo json_encode( $vars );
        exit;
    }
}
?>