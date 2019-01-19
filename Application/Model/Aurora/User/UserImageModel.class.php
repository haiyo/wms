<?php
namespace Aurora\User;
use \Aurora\Component\UploadModel;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
  * @since Saturday, August 4th, 2012
 * @version $Id: UserImageModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserImageModel extends \Model {


    // Properties
    protected $fileInfo;
    protected $UserImage;


    /**
    * UserImageModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->fileInfo = array( );
        $this->UserImage = new UserImage( );
	}


    /**
    * Return total count of records
    * @return int
    */
    public function isFound( $userID ) {
        return $this->UserImage->isFound( $userID );
    }


    /**
    * Return user data by userID
    * @return mixed
    */
    public function getByUserID( $userID, $column ) {
        return $this->UserImage->getByUserID( $userID, $column );
    }


    /**
    * Save user account information
    * @return int
    */
    public function save( $data, $image ) {
        if( $image && isset( $data['userID'] ) && $data['userID'] ) {
            $image = urldecode( $image );

            if( preg_match('/^data:image\/(\w+);base64,/', $image, $type ) ) {
                $image = substr( $image, strpos( $image, ',' ) + 1 );
                $type = strtolower( $type[1] ); // jpg, png, gif

                if( in_array( $type, ['jpg', 'jpeg', 'gif', 'png'] ) ) {
                    $image = base64_decode( $image );

                    if( $image ) {
                        $UploadModel = new UploadModel( );

                        $this->fileInfo['hashDir'] = MD5( date('Y-m-d') ) . '/';

                        $salt =  MD5( microtime( ) . uniqid( mt_rand( ), true ) );
                        $this->fileInfo['name'] = $salt;
                        $this->fileInfo['hashName'] = "{$salt}.{$type}";
                        $this->fileInfo['size'] = $UploadModel->getBase64Size( $image );
                        $this->fileInfo['created'] = date( 'Y-m-d H:i:s' );

                        File::createDir( USER_PHOTO_DIR . $this->fileInfo['hashDir'] );
                        file_put_contents(USER_PHOTO_DIR . $this->fileInfo['hashDir'] . $this->fileInfo['hashName'], $image );

                        $this->fileInfo['uID'] = $UploadModel->saveUpload( $this->fileInfo );

                        $uiInfo = array( );
                        $uiInfo['userID'] = (int)$data['userID'];
                        $uiInfo['uID'] = $this->fileInfo['uID'];
                        $this->UserImage->insert( 'user_image', $uiInfo );
                    }
                }
            }
        }
    }


    /**
    * Delete user account
    * @return int
    */
    public function delete( $userID ) {
        if( $uiInfo = $this->getByUserID( $userID, '*' ) ) {
            $UploadModel = new UploadModel( );
            $UploadModel->deleteFile( $uiInfo['uID'], $uiInfo['hashName'], USER_PHOTO_DIR );

            return $this->UserImage->delete('user_image', 'WHERE userID="' . (int)$userID . '"');
        }
    }
}
?>