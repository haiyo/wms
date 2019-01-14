<?php
namespace Markaxis;
use \Aurora\AuroraView;
use \Library\IO\File;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: HelpView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class HelpView extends AuroraView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $HelpModel;


    /**
    * HelpView Constructor
    * @return void
    */
    function __construct( HelpModel $HelpModel ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Help/HelpRes');
        $this->HelpModel = $HelpModel;
    }


    /**
    * Render main navigation
    * @return str
    */
    public function renderMenu( $css ) {
        $vars = array( 'TPLVAR_URL' => 'admin/alumni/list',
                       'TPLVAR_CLASS_NAME' => $css,
                       'TPLVAR_HAS_UL' => 'has-ul',
                       'LANG_LINK' => $this->L10n->getContents('LANG_KNOWLEDGE_BASE') );

        return $this->render( 'aurora/menu/parentLink.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderGuideMenu( $css ) {
        $vars = array( 'TPLVAR_URL' => 'admin/alumni/list',
                       'TPLVAR_CLASS_NAME' => $css,
                       'TPLVAR_HAS_UL' => 'has-ul',
                       'LANG_LINK' => $this->L10n->getContents('LANG_USER_GUIDE') );

        return $this->render( 'aurora/menu/subLink.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderFAQMenu( $css ) {
        $vars = array( 'TPLVAR_URL' => 'admin/alumni/list',
                       'TPLVAR_CLASS_NAME' => $css,
                       'TPLVAR_HAS_UL' => 'has-ul',
                       'LANG_LINK' => $this->L10n->getContents('LANG_FREQUENTLY_ASKED_QUESTIONS') );

        return $this->render( 'aurora/menu/subLink.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderContactMenu( $css ) {
        $vars = array( 'TPLVAR_URL' => 'admin/alumni/list',
                       'TPLVAR_CLASS_NAME' => $css,
                       'TPLVAR_HAS_UL' => 'has-ul',
                       'LANG_LINK' => $this->L10n->getContents('LANG_CONTACT_HELPDESK') );

        return $this->render( 'aurora/menu/subLink.tpl', $vars );
    }
}
?>