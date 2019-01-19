<?php
namespace Aurora\User;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: UserRoleControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserRoleControl {


    // Properties


    /**
     * UserRoleControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function view( ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function add( ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function edit( $args ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function save( ) {
        $post = Control::getPostData( );

        $UserRoleModel = UserRoleModel::getInstance( );
        $UserRoleModel->save( $post );
    }
}
?>