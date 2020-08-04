<?php
namespace Markaxis\Employee;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: FormWrapperControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class FormWrapperControl {


    // Properties
    protected $FormWrapperView;


    /**
     * FormWrapperControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->FormWrapperView = new FormWrapperView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function profile( ) {
        $output = Control::getOutputArray( );

        $form  = isset( $output['form'] ) ? $output['form'] : '';
        $userInfo  = isset( $output['userInfo'] ) ? $output['userInfo'] : '';
        $photo = isset( $output['photo'] ) ? $output['photo'] : '';

        $this->FormWrapperView->renderProfile( $form, $userInfo, $photo );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function add( ) {
        $output = Control::getOutputArray( );

        $this->FormWrapperView->renderAdd( $output['form'] );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function edit( $args ) {
        $output = Control::getOutputArray( );

        $form  = isset( $output['form'] ) ? $output['form'] : '';
        $userInfo  = isset( $output['userInfo'] ) ? $output['userInfo'] : '';
        $photo = isset( $output['photo'] ) ? $output['photo'] : '';

        $this->FormWrapperView->renderEdit( $form, $userInfo, $photo );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveProfile( ) {
        $this->saveUser( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveUser( ) {
        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }
}
?>