<?php
namespace Aurora\User;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: RoleControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RoleControl {


    // Properties
    private $RoleModel;


    /**
     * RoleControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->RoleModel = RoleModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getRole( $data ) {
        if( isset( $data[1] ) ) {
            $vars = array( );
            $vars['data'] = $this->RoleModel->getByroleID( $data[1] );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveRole( ) {
        if( Control::hasPermission( 'Markaxis', 'add_modify_role' ) ) {
            $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );

            if( $this->RoleModel->isValid( $post ) ) {
                $this->RoleModel->save( );
                $vars['bool'] = 1;
            }
            else {
                $vars['bool'] = 0;
                $vars['errMsg'] = $this->RoleModel->getErrMsg( );
            }
            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deleteRole( ) {
        if( Control::hasPermission( 'Markaxis', 'add_modify_role' ) ) {
            $roleID = Control::getRequest( )->request( POST, 'data' );

            $this->RoleModel->delete( $roleID );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
    }
}
?>