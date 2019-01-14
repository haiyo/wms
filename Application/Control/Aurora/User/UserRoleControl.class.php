<?php
namespace Aurora\User;
use \Library\IO\File;
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

        File::import( MODEL . 'Aurora/User/UserRoleModel.class.php' );
        $UserRoleModel = UserRoleModel::getInstance( );
        $UserRoleModel->save( $post );
    }
}
?>