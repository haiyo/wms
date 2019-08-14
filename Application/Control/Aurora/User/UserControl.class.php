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
    private $UserModel;
    private $UserView;


    /**
     * UserControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->UserModel = new UserModel( );
        $this->UserView = new UserView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function add( ) {
        Control::setOutputArrayAppend( array( 'form' => $this->UserView->renderAdd( ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function edit( $args ) {
        $userID = isset( $args[1] ) ? (int)$args[1] : 0;
        Control::setOutputArrayAppend( array( 'form' => $this->UserView->renderEdit( $userID ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveUser( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );

        if( $this->UserModel->isValid( $post ) ) {
            $post['userID'] = $this->UserModel->save( );

            $ChildrenModel = new ChildrenModel( );
            $ChildrenModel->save( $post );
            Control::setPostData( $post );
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->UserModel->getErrMsg( );
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

        $vars = array( );
        $vars['bool'] = $this->UserModel->setSuspendStatus( $post );

        echo json_encode( $vars );
        exit;
    }
}
?>