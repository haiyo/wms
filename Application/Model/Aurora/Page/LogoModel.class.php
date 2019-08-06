<?php
namespace Aurora\Page;
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
    private $fileInfo;
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
        
        $Authenticator  = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $this->userInfo = $Authenticator->getUserModel( )->getInfo('userInfo');
        
        $this->UserSettingModel = $this->Registry->get( HKEY_CLASS, 'UserSettingModel' );
        
        $this->dir = ROOT . LOGO_DIR . '/' . $this->userInfo['userID'] . '/';
        File::createDir( $this->dir );
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
        $this->fileInfo['hashDir'] = MD5( date('Y-m-d') );
        $dir = $this->dir . $this->fileInfo['hashDir'] . '/';
        File::createDir( $dir );

        $Uploader = new Uploader( array( 'uploadDir' => $dir ) );
        if( $Uploader->validate( $file ) ) {
            $Uploader->upload( );
        }

        $this->fileInfo = array_merge( $this->fileInfo, $Uploader->getFileInfo( ) );

        if( $this->fileInfo['error'] ) {
            $this->setErrMsg( $this->fileInfo['error'] );
            return false;
        }

        if( $this->fileInfo['success'] == 2 ) {
            $path = $this->dir . $this->fileInfo['hashDir'] . '/' . $this->fileInfo['hashName'];
            $this->fileInfo['type'] = mime_content_type( $path );

            //if( $this->fileInfo['isImage'] )
            $this->processResize( );
            
            // Read image path, convert to base64 encoding
            $imageData = base64_encode( file_get_contents( $path ) );
            // Format the image SRC:  data:{mime};base64,{data};
            $this->fileInfo['img'] = 'data: ' . mime_content_type( $path ).';base64,'.$imageData;
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
    public function processResize( ) {
        $fileInfo = explode( '.', $this->fileInfo['hashName'] );
        $this->fileInfo['thumbnail'] = $this->fileInfo['hashDir'] . '/' . $fileInfo[0] . '_thumbnail.'  . $fileInfo[1];

        $ImageManipulation = new ImageManipulation( $this->Registry->get( HKEY_LOCAL, 'imageLib' ) );
        //$ImageManipulation->autoRotate( $this->dir . $this->fileInfo['hashDir'] . '/' . $this->fileInfo['hashName'] );
        $ImageManipulation->copyResized( $this->dir . $this->fileInfo['hashDir'] . '/' . $this->fileInfo['hashName'],
                                         $this->dir . $this->fileInfo['hashDir'] . '/' . $this->fileInfo['hashName'],
                                         self::MAX_WIDTH, self::MAX_HEIGHT, true );
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