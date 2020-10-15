<?php
namespace Markaxis\Payroll;
use \Markaxis\Employee\EmployeeModel;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView, \Aurora\Form\SelectGroupListView;
use \Aurora\Component\OfficeModel, \Aurora\Component\DesignationModel, \Aurora\Component\IdentityTypeModel;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: TaxFileView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxFileView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $TaxFileModel;


    /**
    * TaxFileView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->TaxFileModel = TaxModel::getInstance( );

        $this->View->setJScript( array( 'plugins/moment' => 'moment.min.js',
                                        'plugins/tables/datatables' => array( 'datatables.min.js', 'checkboxes.min.js'),
                                        'plugins/forms' => array( 'wizards/stepy.min.js', 'tags/tokenfield.min.js', 'input/typeahead.bundle.min.js' ),
                                        'plugins/buttons' => array( 'spin.min.js', 'ladda.min.js' ),
                                        'plugins/pickers' => array( 'picker.js', 'picker.date.js', 'daterangepicker.js' ),
                                        'jquery' => array( 'mark.min.js', 'jquery.validate.min.js' ),
                                        'markaxis' => 'taxfile.js' ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderTaxFile( ) {
        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'icon-coins',
                                            'text' => $this->L10n->getContents('LANG_TAX_FILING') ) );

        $vars = array_merge( $this->L10n->getContents( ), array( ) );
        $this->View->printAll( $this->View->render( 'markaxis/payroll/taxFile.tpl', $vars ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderTaxFileForm( ) {
        $SelectListView = new SelectListView( );

        $OfficeModel = OfficeModel::getInstance( );
        $officeList = $SelectListView->build( 'office',  $OfficeModel->getList( ), '', 'Select Office / Location' );

        $currYear = date('Y', strtotime('-1 year') );
        $prevYear = date('Y', strtotime('-3 year') );
        $yearList = array( );

        for( $i=$currYear; $i>=$prevYear; $i-- ) {
            $yearList[$i] = $i;
        }

        $yearList = $SelectListView->build( 'year',  $yearList, '', 'Select Year' );

        $IdentityTypeModel = IdentityTypeModel::getInstance( );
        $idTypeList = $SelectListView->build( 'idType',  $IdentityTypeModel->getList( ), '', 'Select Identity Type' );

        $EmployeeModel = EmployeeModel::getInstance( );
        $empInfo = $EmployeeModel->getInfo( );

        $DesignationModel = DesignationModel::getInstance( );
        $SelectGroupListView = new SelectGroupListView( );
        $designationList = $SelectGroupListView->build( 'designation', $DesignationModel->getGroupList( ), $empInfo['designationID'], 'Select Designation' );

        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_NAME' => $userInfo['fname'] . ' ' . $userInfo['lname'],
                       'TPLVAR_EMAIL' => $userInfo['email1'],
                       'TPLVAR_PHONE' => $userInfo['phone'],
                       'TPLVAR_NRIC' => $userInfo['nric'],
                       'TPL_YEAR_LIST' => $yearList,
                       'TPL_OFFICE_LIST' => $officeList,
                       'TPL_DESIGNATION_LIST' => $designationList,
                       'TPL_IDENTITY_TYPE_LIST' => $idTypeList ) );

        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'icon-coins',
                                            'text' => $this->L10n->getContents('LANG_TAX_FILING') ) );

        $this->View->printAll( $this->View->render( 'markaxis/payroll/taxFileForm.tpl', $vars ) );
    }
}
?>