<?php
namespace Markaxis\Employee;
use \Library\Runtime\Registry, \Aurora\Admin\AdminView, \Aurora\Form\SelectListView;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: DesignationView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DesignationView {


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
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Employee/DesignationRes');

        $this->DesignationModel = DesignationModel::getInstance( );

        $this->View->setJScript( array( 'markaxis' => array( 'designation.js', 'designationGroup.js' ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderGroupList( ) {
        $designationGroupList = $this->DesignationModel->getGroupList( );

        $SelectListView = new SelectListView( );
        return $SelectListView->build('dID', $designationGroupList, '',
                                      'Select Designation Group' );
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderSettings( ) {
        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_HREF' => 'designationList',
                       'LANG_TEXT' => $this->L10n->getContents( 'LANG_DESIGNATION' ),
                       'TPL_DESIGNATION_GROUP_LIST' => $this->renderGroupList( ) ) );

        return array( 'tab' =>  $this->View->render( 'aurora/core/tab.tpl', $vars ),
                      'form' => $this->View->render( 'markaxis/employee/designationList.tpl', $vars ) );
    }
}
?>