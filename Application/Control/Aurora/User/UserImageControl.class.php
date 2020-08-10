<?php
namespace Aurora\User;
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
        $this->UserImageModel = UserImageModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function profile( ) {
        $output = Control::getOutputArray( );

        if( isset( $output['userInfo'] ) ) {
            Control::setOutputArrayAppend( array( 'photo' => $this->UserImageModel->getImgLinkByUserID( $output['userInfo']['userID'], '*' ) ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function photo( $args ) {
        if( isset( $args[1] ) ) {
            if( $imgInfo = $this->UserImageModel->getByUserID( $args[1] ) ) {
                $imgPath = USER_PHOTO_DIR . $imgInfo['hashDir'] . '/' . $imgInfo['hashName'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE );
                $contentType = finfo_file($finfo, $imgPath);
                finfo_close($finfo);

                header('Content-Type: ' . $contentType);
                readfile( $imgPath );
            }
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function edit( $args ) {
        $userID = isset( $args[1] ) ? (int)$args[1] : 0;

        Control::setOutputArrayAppend( array( 'photo' => $this->UserImageModel->getImgLinkByUserID( $userID, '*' ) ) );
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
        $data  = Control::getPostData( );
        $image = Control::getRequest( )->request( POST, 'image' );

        $this->UserImageModel->save( $data, $image );
    }


    /**
     * Render main navigation
     * @return string
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