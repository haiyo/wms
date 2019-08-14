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
    private $UserRoleModel;


    /**
     * UserRoleControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->UserRoleModel = UserRoleModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getCountList( $data ) {
        if( isset( $data[1] ) && $data[1] == 'role' && isset( $data[2] ) ) {
            Control::setOutputArrayAppend( array( 'list' => $this->UserRoleModel->getCountList( $data[2] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveUser( ) {
        $post = Control::getPostData( );
        $this->UserRoleModel->save( $post );
    }
}
?>