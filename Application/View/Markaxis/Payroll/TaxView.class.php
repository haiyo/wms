<?php
namespace Markaxis\Payroll;
use \Aurora\Component\OfficeModel;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView, \Aurora\Form\SelectGroupListView, \Aurora\Form\RadioView;
use \Aurora\Component\CountryModel, \Aurora\Component\DesignationModel, \Aurora\Component\ContractModel;
use \Aurora\Component\RaceModel;
use \Library\Helper\Aurora\GenderHelper;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: TaxView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $TaxModel;


    /**
    * TaxView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->TaxModel = TaxModel::getInstance( );

        $this->View->setJScript( array( ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSettings( $output ) {
        $SelectListView = new SelectListView( );

        $CountryModel = CountryModel::getInstance( );
        $countries = $CountryModel->getList( );
        $countryList = $SelectListView->build( 'country', $countries, '', 'Select Country' );

        $ItemModel = ItemModel::getInstance( );
        $payItemList = $SelectListView->build('payItem_{id}', $ItemModel->getList( ), '', 'Select Pay Item' );

        $OfficeModel = OfficeModel::getInstance( );
        $officeList = $SelectListView->build('office', $OfficeModel->getList( ), '','Select Office / Location' );

        $SelectListView->includeBlank( false );
        $SelectListView->isMultiple( true );

        $ContractModel = ContractModel::getInstance( );
        $contractList = $SelectListView->build( 'contract{template}',
                            $ContractModel->getList( ), '', 'Select Contract Type' );

        $DesignationModel = DesignationModel::getInstance( );

        $SelectGroupListView = new SelectGroupListView( );
        $SelectGroupListView->includeBlank( false );
        $SelectGroupListView->isMultiple( true );
        $designationList = $SelectGroupListView->build( 'designation{template}',
                                $DesignationModel->getGroupList( ), '', 'Select Designation' );

        $RaceModel = RaceModel::getInstance( );
        $raceList = $SelectListView->build( 'race{template}',  $RaceModel->getList( ), '', 'Select Race' );

        $RadioView = new RadioView( );
        $genderRadio  = $RadioView->build( 'gender{template}', GenderHelper::getL10nList( ), '', 'gender' );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPL_COUNTRY_LIST' => $countryList,
                       'TPL_PAY_ITEM_LIST' => $payItemList,
                       'TPL_CONTRACT_LIST' => $contractList,
                       'TPL_OFFICE_LIST' => $officeList,
                       'TPL_DESIGNATION_LIST' => $designationList,
                       'TPL_RACE_LIST' => $raceList,
                       'TPL_GENDER_RADIO' => $genderRadio ) );

        $vars['dynamic']['noGroup'] = false;

        if( isset( $output['groupList'] ) ) {
            $vars['TPL_GROUP_TREE_LIST'] = $output['groupList'];
        }
        return $this->View->render( 'markaxis/payroll/taxes.tpl', $vars );
    }
}
?>