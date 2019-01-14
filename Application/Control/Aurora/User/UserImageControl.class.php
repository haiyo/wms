<?php
namespace Aurora\User;
use \Library\IO\File;
use \Control;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: UserImageControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserImageControl {


    // Properties
    protected $UserImageModel;


    /**
     * UserImageControl Constructor
     * @return void
     */
    function __construct( ) {
        File::import( MODEL . 'Aurora/User/UserImageModel.class.php' );
        $this->UserImageModel = UserImageModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function add( ) {
        /*File::import( VIEW . 'Aurora/User/UserView.class.php' );
        $UserView = new UserView( );
        Control::setOutputArrayAppend( array( 'form' => $UserView->renderAdd( ) ) );*/
    }


    /**
     * Render main navigation
     * @return str
     */
    public function edit( $args ) {
        $userID = isset( $args[1] ) ? (int)$args[1] : 0;

        Control::setOutputArrayAppend( array( 'photo' => $this->UserImageModel->getByUserID( $userID, '*' ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function save( ) {
        $data  = Control::getPostData( );
        $image = Control::getRequest( )->request( POST, 'image' );

        $this->UserImageModel->save( $data, $image );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function deletePhoto( ) {
        $userID = Control::getRequest( )->request( POST, 'userID' );

        if( $userID ) {
            $this->UserImageModel->delete( $userID );
        }
        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }
}
?>