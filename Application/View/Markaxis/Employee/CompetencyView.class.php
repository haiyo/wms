<?php
namespace Markaxis\Employee;
use \Library\Runtime\Registry, \Aurora\Admin\AdminView;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: CompetencyView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CompetencyView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $CompetencyModel;
    protected $info;


    /**
    * CompetencyView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Employee/CompetencyRes');

        $this->CompetencyModel = CompetencyModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderSettings( ) {
        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_HREF' => 'competencyList',
                       'LANG_TEXT' => $this->L10n->getContents( 'LANG_COMPETENCY' ) ) );

        return array( 'tab' =>  $this->render( 'aurora/core/tab.tpl', $vars ),
                      'form' => $this->render( 'markaxis/employee/competencyList.tpl', $vars ) );
    }
}
?>