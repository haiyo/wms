<?php
namespace Aurora;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: AdminView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AdminView extends AuroraView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;


    /**
    * AdminView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct();

        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $this->i18n->loadLanguage('Aurora/Admin/AdminRes');
	}


    /**
    * Render main navigation
    * @return str
    */
    public function renderMenu( $css ) {
        $vars = array( 'TPLVAR_URL' => 'admin/config',
                       'TPLVAR_CLASS_NAME' => $css,
                       'LANG_LINK' => $this->L10n->getContents('LANG_ADMINISTRATIVE_CONTROL') );

        /*
        $Authorization = $this->Registry->get( HKEY_CLASS, 'Authorization' );
        if( $Authorization->hasPermission( 'Aurora', 'change_logo' ) ) {
            $vars['dynamic']['logoTools'][] = true;
        }*/

        return $this->render( 'aurora/menu/parentLink.tpl', $vars );
    }


    /**
    * Render main navigation
    * @return str
    */
    public function renderSysMenu( $css ) {
        $vars = array( 'TPLVAR_URL' => 'admin/config',
                       'TPLVAR_CLASS_NAME' => $css,
                       'LANG_LINK' => $this->L10n->getContents('LANG_SYSTEM_CONFIGURATIONS') );

        return $this->render( 'aurora/menu/subLink.tpl', $vars );
    }
}
?>