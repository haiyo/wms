<?php
namespace Aurora\User;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: RolePermControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RolePermControl {


    // Properties


    /**
    * RolePermControl Constructor
    * @return void
    */
    function __construct( ) {
        //
    }


    /**
     * DashboardControl Main
     * @return void
     */
    public function getMenu( $css ) {
        $RolePermModel = RolePermModel::getInstance( );
        $PermissionModel = PermissionModel::getInstance( );

        $RolePermView = new RolePermView( $RolePermModel, $PermissionModel );
        return $RolePermView->renderMenu( $css );
    }


    /**
    * Generate Role List Form
    * @return void
    */
    public function list( ) {
        $RolePermModel = RolePermModel::getInstance( );
        $PermissionModel = PermissionModel::getInstance( );

        $RolePermView = new RolePermView( $RolePermModel, $PermissionModel );
        $RolePermView->printAll( $RolePermView->renderList( ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getPerms( ) {
        $post = Control::getRequest( )->request( POST );

        $RolePermModel = RolePermModel::getInstance( );
        echo json_encode( $RolePermModel->getByRoleID( $post['roleID'] ) );
        exit;
    }


    /**
    * Save Role and Permissions
    * @return void
    */
    public function savePerms( ) {
        $post = Control::getRequest( )->request( POST );

        $RolePermModel = RolePermModel::getInstance( );
        $RolePermModel->savePerms( $post );
    }


    /**
    * Save Role Title and Description
    * @return void
    */
    public function saveInfo( ) {
        $vars = array( );
        $vars['bool'] = 0;
        $post = Control::getRequest( )->request( POST );

        $RolePermModel = RolePermModel::getInstance( );

        if( !$RolePermModel->setInfo( $post ) ) {
            $vars['errMsg'] = $RolePermModel->getErrMsg( );
        }
        else {
            $RolePermModel->saveInfo( );
            $vars['bool'] = 1;
            $vars = array_merge( $vars, $RolePermModel->getInfo( ) );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
    * Delete Role
    * @return void
    */
    public function delete( ) {
        $vars = array( );
        $vars['bool'] = 0;
        $post = Control::getRequest( )->request( POST, 'roleID' );

        $RolePermModel = RolePermModel::getInstance( );
        
        if( $RolePermModel->delete( $post ) ) {
            $vars['bool'] = 1;
        }
        echo json_encode( $vars );
        exit;
    }
}
?>