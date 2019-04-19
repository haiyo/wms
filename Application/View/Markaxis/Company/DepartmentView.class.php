<?php
namespace Markaxis\Company;
use \Library\Runtime\Registry, \Aurora\Admin\AdminView;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: DepartmentView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DepartmentView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $DepartmentModel;
    protected $info;


    /**
    * DepartmentView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Company/DepartmentRes');

        $this->DepartmentModel = DepartmentModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSettings( ) {
        $vars = array_merge( $this->L10n->getContents( ),
            array( ) );

        return $this->render( 'markaxis/company/departmentList.tpl', $vars );
    }
}
?>