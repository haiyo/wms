<?php
namespace Markaxis\Employee;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: SupervisorControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class SupervisorControl {


    // Properties


    /**
     * SupervisorControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return string
     */
    public function view( ) {
        //
    }


    /**
     * Render main navigation
     * @return string
     */
    public function add( ) {
        //
    }


    /**
     * Render main navigation
     * @return string
     */
    public function edit( $args ) {
        //
    }


    /**
     * Render main navigation
     * @return string
     */
    public function save( ) {
        $post = Control::getPostData( );

        $SupervisorModel = SupervisorModel::getInstance( );
        $SupervisorModel->save( $post );
    }
}
?>