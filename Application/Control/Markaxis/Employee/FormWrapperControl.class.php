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


    /**
     * FormWrapperControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return string
     */
    public function add( ) {
        $output = Control::getOutputArray( );

        $FormWrapperView = new FormWrapperView( );
        $FormWrapperView->printAll( $FormWrapperView->renderAdd( $output['form'] ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function edit( $args ) {
        $userID = isset( $args[1] ) ? (int)$args[1] : 0;
        $output = Control::getOutputArray( );

        $form  = isset( $output['form'] ) ? $output['form'] : '';
        $photo = isset( $output['photo'] ) ? $output['photo'] : '';

        $FormWrapperView = new FormWrapperView( );
        $FormWrapperView->printAll( $FormWrapperView->renderEdit( $form, $userID, $photo ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function save( ) {
        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }
}
?>