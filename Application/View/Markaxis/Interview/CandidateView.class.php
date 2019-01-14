<?php
namespace Markaxis;
use \Aurora\AuroraView;
use \Library\IO\File;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: CandidateView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CandidateView extends AuroraView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $CandidateModel;


    /**
    * CandidateView Constructor
    * @return void
    */
    function __construct( CandidateModel $CandidateModel ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Interview/CandidateRes');
        $this->CandidateModel = $CandidateModel;
    }


    /**
    * Render main navigation
    * @return str
    */
    public function renderMenu( $css ) {
        $vars = array( 'TPLVAR_URL' => 'admin/alumni/list',
                       'TPLVAR_CLASS_NAME' => $css,
                       'TPLVAR_HAS_UL' => 'has-ul',
                       'LANG_LINK' => $this->L10n->getContents('LANG_ALUMNI_MANAGEMENT') );

        return $this->render( 'aurora/menu/subLink.tpl', $vars );
    }
}
?>