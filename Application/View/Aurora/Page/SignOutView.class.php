<?php
namespace Aurora\Page;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: SignOutView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class SignOutView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;


    /**
    * SignOutView Constructor
    * @return void
    */
    function __construct( ) {
        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $this->i18n->loadLanguage('Aurora/NavRes');
        $this->View = AuroraView::getInstance( );
	}


    /**
    * Render main navigation
    * @return str
    */
    public function getMainMenu( ) {
        $vars = array( 'TPLVAR_URL' => 'admin/logout',
                       'TPLVAR_CLASS_NAME' => 'signoutLink signout',
                       'LANG_LINK'  => $this->L10n->getContents('LANG_SIGN_OUT') );

        return $this->View->render( 'aurora/navigation/html/parentLink.tpl', $vars );
    }
}
?>