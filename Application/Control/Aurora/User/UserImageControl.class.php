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
                $filename = USER_PHOTO_DIR . $imgInfo['hashDir'] . '/' . $imgInfo['hashName'];

                $mimeType = File::getType( $filename );
                $content = file_get_contents( $filename );
                header('Content-Type: ' . $mimeType);
                header('Content-Length: '.strlen( $content ));
                header('Content-disposition: inline; filename="' . $imgInfo['name'] . '"');
                header('Cache-Control: public, must-revalidate, max-age=0');
                header('Pragma: public');
                header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
                header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
                echo $content;
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