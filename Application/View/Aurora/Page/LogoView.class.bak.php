<?php
namespace Aurora\Page;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LogoView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LogoView {


    // Properties
    protected $Registry;
    protected $HKEY_LOCAL;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $LogoModel;


    /**
    * LogoView Constructor
    * @return void
    */
    function __construct( LogoModel $LogoModel ) {
        $this->Registry = Registry::getInstance( );
        $this->HKEY_LOCAL = $this->Registry->get( HKEY_LOCAL );
        $this->View = LightboxView::getInstance( );
        $this->LogoModel = $LogoModel;

        $this->i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $this->i18n->loadLanguage('Aurora/LogoRes');
        
        $Authenticator  = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $this->userInfo = $Authenticator->getUserModel( )->getInfo('userInfo');
	}


    /**
    * Render Upload Form
    * @return string
    */
    public function render( ) {
        $UserSettingModel = $this->Registry->get( HKEY_CLASS, 'UserSettingModel' );
        $userSetInfo = $UserSettingModel->getInfo( );
        
        $logoImage = '';
        if( $userSetInfo['logoImage'] != '' ) {
            $path = ROOT . LOGO_DIR . $this->userInfo['userID'] . '/' . $userSetInfo['logoImage'];
            // Read image path, convert to base64 encoding
            $imageData = base64_encode( file_get_contents( $path ) );
            // Format the image SRC:  data:{mime};base64,{data};
            $logoImage = 'data: ' . mime_content_type( $path ).';base64,'.$imageData;
        }
        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_LOGO' => $logoImage ) );

        $btn = array( );
        $btn['delete'] = array( 'class' => 'delete',
                                'text'  => $this->L10n->getContents('LANG_REMOVE_LOGO') );
        
        $this->View->setJScript( array( 'aurora.logo.i18n' => 'locale/' . $this->L10n->getL10n( ),
                                        'aurora.uploader' => 'aurora/aurora.uploader.js',
                                        'aurora.logo' => 'aurora/page/aurora.logo.js' ) );
        
        $this->View->setTitle( $this->L10n->getContents('LANG_UPLOAD_LOGO') );
        $this->View->setButtons( $btn );
        return $this->View->render( 'aurora/page/html/logo.tpl', $vars );
    }
}
?>