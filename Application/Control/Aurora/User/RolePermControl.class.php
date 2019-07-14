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
    private $RolePermModel;
    private $PermissionModel;
    private $RolePermView;


    /**
    * RolePermControl Constructor
    * @return void
    */
    function __construct( ) {
        $this->RolePermModel = RolePermModel::getInstance( );
        $this->PermissionModel = PermissionModel::getInstance( );
        $this->RolePermView = new RolePermView( $this->RolePermModel, $this->PermissionModel );
    }


    /**
     * DashboardControl Main
     * @return string
     */
    public function getMenu( $css ) {
        return $this->RolePermView->renderMenu( $css );
    }


    /**
    * Generate Role List Form
    * @return void
    */
    public function settings( ) {
        if( Control::hasPermission( 'Markaxis', 'add_modify_role' ) ) {
            Control::setOutputArrayAppend( $this->RolePermView->renderSettings( ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getRolePermResults( ) {
        $post = Control::getRequest( )->request( POST );
        echo json_encode( $this->RolePermModel->getResults( $post ) );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getPerms( ) {
        $post = Control::getRequest( )->request( POST );
        echo json_encode( $this->RolePermModel->getByRoleID( $post['roleID'] ) );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getPermList( $args ) {
        if( isset( $args[1] ) ) {
            echo $this->RolePermView->renderPermList( $args[1] );
            exit;
        }
    }


    /**
    * Save Role and Permissions
    * @return void
    */
    public function savePerms( ) {
        $post = Control::getRequest( )->request( POST );
        $this->RolePermModel->savePerms( $post );
        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }


    /**
    * Save Role Title and Description
    * @return void
    */
    public function saveInfo( ) {
        $vars = array( );
        $vars['bool'] = 0;
        $post = Control::getRequest( )->request( POST );

        if( !$this->RolePermModel->setInfo( $post ) ) {
            $vars['errMsg'] = $this->RolePermModel->getErrMsg( );
        }
        else {
            $this->RolePermModel->saveInfo( );
            $vars['bool'] = 1;
            $vars = array_merge( $vars, $this->RolePermModel->getInfo( ) );
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
        
        if( $this->RolePermModel->delete( $post ) ) {
            $vars['bool'] = 1;
        }
        echo json_encode( $vars );
        exit;
    }
}
?>