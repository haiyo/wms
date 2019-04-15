<?php
namespace Markaxis\Interview;
use \Aurora\Admin\AdminView;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: InterviewView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class InterviewView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $InterviewModel;


    /**
    * InterviewView Constructor
    * @return void
    */
    function __construct( InterviewModel $InterviewModel ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Interview/InterviewRes');
        $this->InterviewModel = $InterviewModel;
    }


    /**
    * Render main navigation
    * @return string
    */
    public function renderMenu( $css ) {
        $vars = array( 'TPLVAR_URL' => 'admin/interview/list',
                       'TPLVAR_CLASS_NAME' => $css,
                       'TPLVAR_HAS_UL' => 'has-ul',
                       'LANG_LINK' => $this->L10n->getContents('LANG_INTERVIEW_TOOLKIT') );

        return $this->render( 'aurora/menu/parentLink.tpl', $vars );
    }
}
?>