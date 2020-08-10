<?php
namespace Aurora;
use \Aurora\Admin\AdminView;
use \Markaxis\Company\CompanyModel;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LoginView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LoginView extends AdminView {


    // Properties
    protected $Registry;
    protected $HKEY_LOCAL;
    protected $L10n;
    protected $View;


    /**
    * LoginView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct();

        $this->Registry = Registry::getInstance( );
        $this->HKEY_LOCAL = $this->Registry->get( HKEY_LOCAL );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/LoginRes');

        $this->setJScript( array( 'jquery' => 'jquery.validate.min.js',
                                  'pages' => array( 'aurora.login.js' ),
                                  'locale' => $this->L10n->getL10n( ) ) );
	}

    
    /**
    * Render Login Page
    * @return string
    */
    public function renderLogin( ) {
        $CompanyModel = CompanyModel::getInstance( );
        $companyInfo = $CompanyModel->getInfo( );

        $websiteName = $this->HKEY_LOCAL['websiteName'];
        $title = $this->L10n->strReplace( 'WEBSITE_NAME', $websiteName, 'LANG_LOGIN_TITLE' );

        $this->setTitle( $title );
        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_MAIN_COLOR' => $companyInfo['mainColor'],
                       'TPLVAR_BUTTON_COLOR' => $companyInfo['buttonColor'],
                       'TPLVAR_BUTTON_HOVER_COLOR' => $companyInfo['buttonHoverColor'],
                       'TPLVAR_BUTTON_FOCUS_COLOR' => $companyInfo['buttonFocusColor'] ) );

        return  $this->render( 'aurora/login/login.tpl', $vars );
	}


    /**
     * Render header
     * @return string
     */
    public function renderNavBar( ) {
        return $this->render( 'aurora/login/navBar.tpl', array( ) );
    }


    /**
     * Print all
     * @return void
     */
    public function printAll( $template, $nav=false ) {
        $vars = array( 'TPL_HEADER' => $this->renderHeader( ),
                        'TPL_NAV_BAR' => $this->renderNavBar( ),
                        'TPL_CONTENT' => $template );
        echo $this->render( 'aurora/page/left.tpl', $vars );
    }
}
?>