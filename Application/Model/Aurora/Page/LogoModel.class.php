<?php
namespace Aurora\Page;
use \Aurora\User\UserModel;
use \Library\IO\File, \Library\Util\Uploader, \Library\Util\ImageManipulation;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LogoModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LogoModel extends \Model {


    // Properties
    private $UserSettingModel;
    private $Uploader;
    private $userInfo;
    private $dir;
    
    const MAX_WIDTH = 500;
    const MAX_HEIGHT = 90;


    /**
    * LogoModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->userInfo = UserModel::getInstance( )->getInfo( );
        
        $this->UserSettingModel = $this->Registry->get( HKEY_CLASS, 'UserSettingModel' );
	}
    
    
    /**
    * Get File Information
    * @return mixed
    */
    public function getFileInfo( ) {
        return $this->fileInfo;
    }


    /**
    * Update Logo Text
    * @return mixed
    */
    public function updateTxt( $info ) {
        $this->info['logoTxt'] = htmlspecialchars( trim( $info['logoTxt'] ) );
        //$this->Registry->update( 'logoTxt', $this->info['logoTxt'] );
        $this->UserSettingModel->save( $this->userInfo['userID'], 'logoTxt', $this->info['logoTxt'] );
    }


    /**
    * Upload file
    * @return bool
    */
    public function uploadSuccess( $file ) {
        $this->Uploader = new Uploader([
            'uploadDir' => LOGO_DIR
        ]);

        if( $this->Uploader->validate( $file ) && $this->Uploader->upload( ) ) {
            $fileInfo = $this->Uploader->getFileInfo( );
        }

        if( $fileInfo['error'] ) {
            $this->setErrMsg( $fileInfo['error'] );
            return false;
        }

        if( $fileInfo['success'] == 2 ) {
            $path = $fileInfo['uploadDir'] . '/' . $fileInfo['hashName'];
            $fileInfo['type'] = mime_content_type( $path );

            //if( $this->fileInfo['isImage'] )
            $this->processResize( $fileInfo );
            
            // Read image path, convert to base64 encoding
            $imageData = base64_encode( file_get_contents( $path ) );
            // Format the image SRC:  data:{mime};base64,{data};
            $fileInfo['img'] = 'data: ' . mime_content_type( $path ).';base64,'.$imageData;
        }

        /*switch( $this->fileInfo['error'] ) {
            case 'missingFileName' :
            $this->setErrMsg( $this->MessageRes->getContents('LANG_INVALID_MESSAGE') );
            break;
        }*/
        return true;
	}
    
    
    /**
    * Process Image Resize
    * @return void
    */
    public function processResize( $fileInfo ) {
        $info = explode( '.', $fileInfo['hashName'] );
        $fileInfo['thumbnail'] = $fileInfo['hashDir'] . '/' . $info[0] . '_thumbnail.'  . $info[1];

        $ImageManipulation = new ImageManipulation( $this->Registry->get( HKEY_LOCAL, 'imageLib' ) );

        $ImageManipulation->copyResized( $fileInfo['uploadDir'] . $fileInfo['hashName'], $fileInfo['thumbnail'],
                                        self::MAX_WIDTH, self::MAX_HEIGHT, false );
    }
    
    
    /**
    * Update User Setting
    * @return mixed
    */
    public function updateUserSetting( ) {
        $this->UserSettingModel->save( $this->userInfo['userID'], 'logoImage',
                                       $this->fileInfo['hashDir'] . '/' .
                                       $this->fileInfo['hashName'] );
    }


    /**
    * Remove Logo Image
    * @return mixed
    */
    public function remove( $update=true ) {
        $userSetInfo = $this->UserSettingModel->getInfo( );

        if( $userSetInfo['logoImage'] != '' ) {
            // Remove old logo
            $hashes = explode( '/', $userSetInfo['logoImage'] );
            $logoImage = $this->dir . $userSetInfo['logoImage'];
            if( is_file( $logoImage ) ) {
                @unlink( $logoImage );
                @rmdir( $this->dir . $hashes[0] );
            }
            if( $update )
            $this->UserSettingModel->save( $this->userInfo['userID'], 'logoImage', '' );
        }
    }
}
?>