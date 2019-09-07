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
    private $LeaveView;


    /**
     * LeaveControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->LeaveView = new LeaveView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function dashboard( ) {
        Control::setOutputArrayAppend( array( 'sidebarCards' => $this->LeaveView->getSidebar( ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function balance( ) {
        $this->LeaveView->renderBalance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function settings( ) {
        $output = Control::getOutputArray( );
        $this->LeaveView->renderSettings( $output['form'] );
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