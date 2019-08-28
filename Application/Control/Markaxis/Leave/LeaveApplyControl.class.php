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

        if( sizeof( $empInfo ) > 0 && isset( $data['leaveTypes'] ) && is_array( $data['leaveTypes'] ) &&
            sizeof( $data['leaveTypes'] ) > 0 ) {
            Control::setOutputArray( array( 'leaveTypes' => $this->LeaveApplyModel->getByUserLeaveTypeCurrYear( $empInfo['userID'], $data['leaveTypes'] ) ) );
        }
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
    public function dashboard( ) {
        Control::setOutputArrayAppend( $this->LeaveApplyView->renderApplyForm( ) );
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
     * Render main navigation
     * @return string
     */
    public function processPayroll( $args ) {
        if( isset( $args[1] ) && isset( $args[2] ) ) {
            $data = Control::getOutputArray( );
            Control::setOutputArray( $this->LeaveApplyModel->processPayroll( $args[1], $args[2], $data ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function savePayroll( ) {
        $data = Control::getOutputArray( );
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST ) );
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
}
?>