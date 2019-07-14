<?php
namespace Markaxis\Leave;
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
    public function getHistory( ) {
        $post = Control::getRequest( )->request( POST );
        Control::setOutputArray( array( 'list' => $this->LeaveApplyModel->getHistory( $post ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getDateDiff( ) {
        $post = Control::getRequest( )->request( POST );

        if( $diff = $this->LeaveApplyModel->calculateDateDiff( $post ) ) {
            $vars['bool'] = 1;
            $vars['text'] = $diff['text'];
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->LeaveApplyModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
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
    public function dashboard( ) {
        $output = Control::getOutputArray( );

        if( isset( $output['balance'] ) ) {
            Control::setOutputArray( array( 'balance' => $this->LeaveApplyModel->calculateBalance( $output['balance'] ) ) );
        }
        Control::setOutputArrayAppend( $this->LeaveApplyView->renderApplyForm( ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function apply( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );

        if( $this->LeaveApplyModel->applyIsValid( $post ) ) {
            $this->LeaveApplyModel->save( );
            Control::setPostData( array_merge( $post, $this->LeaveApplyModel->getInfo( ) ) );
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->LeaveApplyModel->getErrMsg( );
            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( $args ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( $this->LeaveApplyModel->processPayroll( $args[1], $data ) );
    }
}
?>