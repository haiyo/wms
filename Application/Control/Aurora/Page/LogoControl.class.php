<?php
namespace Aurora\Page;
use \Library\IO\File;
use \Control;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LogoControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LogoControl {


    // Properties


    /**
    * LogoControl Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * Generate Upload Form
    * @return void
    */
    public function logo( ) {
        File::import( MODEL . 'Aurora/Page/LogoModel.class.php' );
        $LogoModel = LogoModel::getInstance( );

        File::import( VIEW . 'Aurora/AuroraView.class.php' );
        File::import( VIEW . 'Aurora/LightboxView.class.php' );
        File::import( VIEW . 'Aurora/Page/LogoView.class.php' );
        $LogoView = new LogoView( $LogoModel );
        $LightboxView = LightboxView::getInstance( );
        $LightboxView->printAll( $LogoView->render( ) );
    }


    /**
    * Update Logo Text
    * @return void
    */
    public function updateTxt( ) {
        $post = Control::getRequest( )->request( POST );

        File::import( MODEL . 'Aurora/Page/LogoModel.class.php' );
        $LogoModel = LogoModel::getInstance( );
        $LogoModel->updateTxt( $post );
        $info = $LogoModel->getInfo( );
        echo json_encode( $info );
        exit;
    }


    /**
    * Upload Logo Image
    * @return void
    */
    public function upload( ) {
        // COR not enabled
        //header('Access-Control-Allow-Origin: *');
        header( 'Access-Control-Allow-Credentials: true' );
        header( 'Pragma: no-cache' );
        header( 'Cache-Control: no-store, no-cache, must-revalidate' );
        header( 'X-Content-Type-Options: nosniff' );
        header( 'Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size' );
        
        $vars = array( );
        $file = Control::getRequest( )->request( FILES );

        File::import( MODEL . 'Aurora/Page/LogoModel.class.php' );
        $LogoModel = LogoModel::getInstance( );
        
        if( $LogoModel->uploadSuccess( $file['file'] ) ) {
            $vars = $LogoModel->getFileInfo( );
            
            if( $vars['success'] == 2 ) {
                $LogoModel->remove( false );
                $LogoModel->updateUserSetting( );
            }
        }
        else {
            $vars['errMsg'] = $LogoModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
    * Remove Logo Image
    * @return void
    */
    public function remove( ) {
        File::import( MODEL . 'Aurora/Page/LogoModel.class.php' );
        $LogoModel = LogoModel::getInstance( );
        $LogoModel->remove( );
        $vars = array( );
        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }
}
?>