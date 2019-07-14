<?php
namespace Aurora\Page;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: NavigationView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NavigationView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $NavigationModel;
    protected $args;


    /**
    * NavigationView Constructor
    * @return void MessageModel $MessageModel
    */
    function __construct( NavigationModel $NavigationModel, $args ) {
        $this->Registry = Registry::getInstance( );
        $this->View = AuroraView::getInstance( );
        $this->NavigationModel = $NavigationModel;
        $this->args = $args;

        $this->i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $this->i18n->loadLanguage('Aurora/NavRes');

        $websiteName = $this->Registry->get( HKEY_LOCAL, 'websiteName' );
        $this->L10n->strReplace( 'WEBSITE_NAME', $websiteName, 'LANG_SIGN_OUT_CONFIRM');
        $this->View->setJScript( array( 'aurora.nav.i18n' => 'locale/' . $this->L10n->getL10n( ) ) );
	}


    /**
    * Get Navigation Class
    * @return string
    */
    public function getNavClass( $folder, $namespace, $className ) {
        static $nav;
        $class  = $namespace . '\\' . $className;

        if( !isset( $nav[$class] ) ) {
            $Menu = new $class;
            $nav[$class] = $Menu;
        }
        return $nav[$class];
    }


    /**
    * Render account header
    * @return string
    */
    public function renderAcctHeader( ) {
        $menuSet = $this->NavigationModel->getMenu( );
        $menu    = '';
        $Authorization = $this->Registry->get( HKEY_CLASS, 'Authorization' );

        foreach( $menuSet as $value ) {
            if( $value['perm'] ) {
                if( !$Authorization->isAdmin( ) && !$Authorization->hasAnyRole( $value['perm'] ) ) {
                    continue;
                }
            }
            $class   = $this->getNavClass( $value['folder'], $value['namespace'], $value['class'] );
            $subMenu = '';
            if( isset( $value['child'] ) ) {
                foreach( $value['child'] as $sub ) {
                    if( $sub['perm'] ) {
                        if( !$Authorization->isAdmin( ) && !$Authorization->hasAnyRole( $sub['perm'] ) ) {
                            continue;
                        }
                    }
                    $subClass = $this->getNavClass( $sub['folder'], $sub['namespace'], $sub['class'] );
                    $subMenu .= $subClass->{$sub['method']}( );
                }
            }            
            $vars = array( 'TPLVAR_CLASS_NAME' => $subMenu ? 'dropdown' : '',
                           'TPL_PARENT_LINK'   => $class->{$value['method']}( $value['css'] ),
                           'TPL_SUB_MENU'      => $subMenu );

            $menu .= $this->View->render( 'aurora/navigation/html/navParent.tpl', $vars );
        }
        
        $UserRes = $this->i18n->loadLanguage('Aurora/User/UserRes');
        $vars = array_merge( $this->L10n->getContents( ),
                             $UserRes->getContents( ),
                array( 'TPLVAR_AURORA_VER' => AURORA_VERSION,
                       'TPL_COMPANY_LOGO'  => $this->renderLogo( ),
                       'TPL_SEARCH_BOX'    => $this->renderSearch( ),
                       'TPL_MENU'          => $menu ) );

        return $this->View->render( 'aurora/core/html/accountHeader.tpl', $vars );
    }


    /**
    * Render Company Logo
    * @return string
    */
    public function renderLogo( ) {
        $Authenticator  = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo('userInfo');
        
        $UserSettingModel = $this->Registry->get( HKEY_CLASS, 'UserSettingModel' );
        $userSetInfo = $UserSettingModel->getInfo( );
        
        $logoImage = '';
        if( $userSetInfo['logoImage'] != '' ) {
            $path = ROOT . LOGO_DIR . $userInfo['userID'] . '/' . $userSetInfo['logoImage'];
            // Read image path, convert to base64 encoding
            $imageData = base64_encode( file_get_contents( $path ) );
            // Format the image SRC:  data:{mime};base64,{data};
            $logoImage = 'data: ' . mime_content_type( $path ).';base64,'.$imageData;
        }
        $logoDisplay = $logoImage == '' ? 'none' : '';
        $logoTxt     = $userSetInfo['logoTxt'] == '' ? $this->Registry->get( HKEY_LOCAL, 'websiteName' ) :
                                                       $userSetInfo['logoTxt'];
        $textDisplay = $logoImage == '' ? '' : 'none';

        $vars['dynamic']['logoTools'] = false;
        $Authorization = $this->Registry->get( HKEY_CLASS, 'Authorization' );
        if( $Authorization->hasPermission( 'Aurora', 'change_logo' ) ) {
            $vars['dynamic']['logoTools'][] = true;
        }

        // Note: Regardless of on/off, we still generate the HTML becos its trigger via JS
        $displayLogo = $this->Registry->get( HKEY_LOCAL, 'displayLogo' ) ? '' : 'none';

        $vars = array_merge( $this->L10n->getContents( ),
                $vars,
                array( 'TPLVAR_LOGO_TEXT'    => $logoTxt,
                       'TPLVAR_LOGO_IMAGE'   => $logoImage,
                       'TPLVAR_LOGO_DISPLAY' => $logoDisplay,
                       'TPLVAR_TEXT_DISPLAY' => $textDisplay,
                       'TPLVAR_COMPANY_LOGO' => $displayLogo ) );

        return $this->View->render( 'aurora/core/html/companyLogo.tpl', $vars );
    }
    
    
    /**
    * Render Search Box
    * @return string
    */
    public function renderSearch( ) {
        $Authorization = $this->Registry->get( HKEY_CLASS, 'Authorization' );
        if( !$Authorization->isAdmin( ) || !$Authorization->hasPermission( 'Aurora', 'search_box' ) ) {
            return '';
        }
        $vars = array_merge( $this->L10n->getContents( ),
                array( ) );

        return $this->View->render( 'aurora/core/html/searchBox.tpl', $vars );
    }
}
?>