<?php
namespace Markaxis\Employee;
use \Library\Runtime\Registry, \Aurora\Admin\AdminView;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: DesignationView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DesignationView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $DesignationModel;
    protected $info;


    /**
    * DesignationView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Employee/DesignationRes');

        $this->DesignationModel = DesignationModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSettings( ) {
        $vars = array_merge( $this->L10n->getContents( ),
            array( ) );

        return $this->render( 'markaxis/employee/designationList.tpl', $vars );
    }
}
?>