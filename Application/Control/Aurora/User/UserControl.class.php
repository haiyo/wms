<?php
namespace Aurora\User;
use \Control;
use \Library\Http\HttpResponse;
use \Library\Exception\Aurora\PageNotFoundException;

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
    public function profile( ) {
        Control::setOutputArrayAppend( $this->UserView->renderProfile( ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getEvents( ) {
        $post = Control::getRequest( )->request( POST );

        if( isset( $post['type'] ) && $post['type'] == 'birthday' ) {
            if( $eventInfo = $this->UserModel->getEvents( $post ) ) {
                Control::setOutputArrayAppend( array( 'events' => $eventInfo ) );
            }
        }
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
        try {
            $userID = isset( $args[1] ) ? (int)$args[1] : 0;

            if( $userInfo = $this->UserModel->getFieldByUserID( $userID, 'u.*' ) ) {
                Control::setOutputArrayAppend( array( 'userInfo' => $userInfo,
                                                      'form' => $this->UserView->renderEdit( $userInfo ) ) );
            }
            else {
                throw( new PageNotFoundException( HttpResponse::HTTP_NOT_FOUND ) );
            }
        }
        catch( PageNotFoundException $e ) {
            $e->record( );
            HttpResponse::sendHeader( HttpResponse::HTTP_NOT_FOUND );
            header( 'location: ' . ROOT_URL . 'admin/notfound' );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveProfile( ) {
        $this->saveUser( );
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
        $this->UserModel->setSuspendStatus( $post );

        $vars = array( );
        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return void
     */
    public function delete( ) {
        if( Control::hasPermission('Markaxis', 'add_modify_employee' ) ) {
            $post = Control::getRequest( )->request( POST );
            $this->UserModel->delete( $post );

            $vars = array( );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
    }
}
?>