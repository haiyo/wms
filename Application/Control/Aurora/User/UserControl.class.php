<?php
namespace Aurora\User;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: UserControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserControl {


    // Properties


    /**
     * UserControl Constructor
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
        $UserView = new UserView( );
        Control::setOutputArrayAppend( array( 'form' => $UserView->renderAdd( ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function edit( $args ) {
        $userID = isset( $args[1] ) ? (int)$args[1] : 0;

        $UserView = new UserView( );
        Control::setOutputArrayAppend( array( 'form' => $UserView->renderEdit( $userID ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function save( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );

        $UserModel = new UserModel( );

        if( $UserModel->isValid( $post ) ) {
            $post['userID'] = $UserModel->save( );

            $ChildrenModel = new ChildrenModel( );
            $ChildrenModel->save( $post );

            Control::setPostData( $post );
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $UserModel->getErrMsg( );
            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function setSuspendStatus( ) {
        $post = Control::getRequest( )->request( POST );

        $UserModel = UserModel::getInstance( );

        $vars = array( );
        $vars['bool'] = $UserModel->setSuspendStatus( $post );

        echo json_encode( $vars );
        exit;
    }
}
?>