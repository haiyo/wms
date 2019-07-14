<?php
namespace Aurora;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ForgotPasswordView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ForgotPasswordView extends LoginView {


    // Properties
    protected $Registry;
    protected $HKEY_LOCAL;
    protected $L10n;
    protected $View;


    /**
    * ForgotPasswordView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct();

        $this->Registry = Registry::getInstance( );
        $this->HKEY_LOCAL = $this->Registry->get( HKEY_LOCAL );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/ForgotPasswordRes');
        $this->UserL10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->setJScript( array( 'jquery' => 'jquery.validate.min.js',
                                  'pages' => array( 'aurora.login.js' ),
                                  'locale' => $this->L10n->getL10n( ) ) );
	}

    
    /**
    * Render Login Page
    * @return string
    */
    public function renderChangePassword( $token ) {
        $vars = array_merge( $this->L10n->getContents( ),
                array_merge( $this->UserL10n->getContents( ),
                array( 'TPLVAR_TOKEN' => $token ) ) );

        return  $this->render( 'aurora/login/changePassword.tpl', $vars );
    }
}
?>