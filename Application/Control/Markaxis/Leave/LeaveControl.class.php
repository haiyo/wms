<?php
namespace Markaxis\Leave;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: LeaveControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveControl {


    // Properties


    /**
     * LeaveControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function dashboard( ) {
        $LeaveView = new LeaveView( );
        Control::setOutputArrayAppend( $LeaveView->renderApplyForm( ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function balance( ) {
        $output = Control::getOutputArray( );

        $LeaveView  = new LeaveView( );
        $LeaveView->printAll( $LeaveView->renderBalance( ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function settings( ) {
        $output = Control::getOutputArray( );

        $LeaveView  = new LeaveView( );
        $LeaveView->printAll( $LeaveView->renderSettings( $output['form'] ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function addType( ) {
        $output = Control::getOutputArray( );

        $LeaveView  = new LeaveView( );
        $LeaveView->printAll( $LeaveView->renderTypeForm( $output['form'] ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function editType( $args ) {
        $output = Control::getOutputArray( );
        $ltID = isset( $args[1] ) ? (int)$args[1] : 0;

        $LeaveView  = new LeaveView( );
        $LeaveView->printAll( $LeaveView->renderTypeForm( $output['form'], $ltID ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function saveType( ) {;
        $post = Control::getPostData( );
        echo json_encode( $post );
        exit;
    }
}
?>