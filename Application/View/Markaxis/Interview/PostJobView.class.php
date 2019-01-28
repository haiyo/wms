<?php
namespace Markaxis\PostJob;
use \Aurora\Admin\AdminView;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PostJobView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PostJobView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $PostJobModel;


    /**
    * PostJobView Constructor
    * @return void
    */
    function __construct( PostJobModel $PostJobModel ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/PostJob/PostJobRes');
        $this->PostJobModel = $PostJobModel;
    }


    /**
    * Render main navigation
    * @return str
    */
    public function renderMenu( $css ) {
        $vars = array( 'TPLVAR_URL' => 'admin/alumni/list',
                       'TPLVAR_CLASS_NAME' => $css,
                       'TPLVAR_HAS_UL' => 'has-ul',
                       'LANG_LINK' => $this->L10n->getContents('LANG_POST_A_JOB') );

        return $this->render( 'aurora/menu/subLink.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderInternalJobMenu( $css ) {
        $vars = array( 'TPLVAR_URL' => 'admin/alumni/list',
            'TPLVAR_CLASS_NAME' => $css,
            'TPLVAR_HAS_UL' => 'has-ul',
            'LANG_LINK' => $this->L10n->getContents('LANG_INTERNAL_JOB_POSTING') );

        return $this->render( 'aurora/menu/subLink.tpl', $vars );
    }
}
?>