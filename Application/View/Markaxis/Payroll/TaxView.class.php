<?php
namespace Markaxis\Payroll;
use \Aurora\AuroraView, \Aurora\Form\SelectListView, \Aurora\Form\SelectGroupListView, \Aurora\Form\RadioView;
use \Aurora\Component\CountryModel, \Aurora\Component\DesignationModel, \Aurora\Component\ContractModel;
use \Library\Helper\Aurora\GenderHelper;
use \Library\IO\File;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: TaxView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxView extends AuroraView {


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
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        File::import( MODEL . 'Markaxis/Payroll/TaxModel.class.php' );
        $TaxModel = TaxModel::getInstance( );
        $this->TaxModel = $TaxModel;

        $this->setJScript( array( ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderSettings( $output ) {
        File::import( VIEW . 'Aurora/Form/SelectListView.class.php' );
        $SelectListView = new SelectListView( );

        File::import( MODEL . 'Aurora/Component/CountryModel.class.php' );
        $CountryModel = CountryModel::getInstance( );
        $countryList  = $SelectListView->build( 'country', $CountryModel->getList( ),
                            $this->Registry->get(HKEY_LOCAL, 'companyCountry'), 'Select  Country' );

        File::import( MODEL . 'Aurora/Component/ContractModel.class.php' );
        $ContractModel = ContractModel::getInstance( );
        $contractList = $SelectListView->build( 'contract_{id}',
                            $ContractModel->getList( ), '', 'Select Contract Type' );

        File::import( MODEL . 'Aurora/Component/DesignationModel.class.php' );
        $DesignationModel = DesignationModel::getInstance( );

        File::import( VIEW . 'Aurora/Form/SelectGroupListView.class.php' );
        $SelectGroupListView = new SelectGroupListView( );
        $designationList = $SelectGroupListView->build( 'designation_{id}',
                                $DesignationModel->getList( ), '', 'Select Designation' );

        File::import( VIEW . 'Aurora/Form/RadioView.class.php' );
        $RadioView = new RadioView( );
        $genderRadio  = $RadioView->build( 'gender{template}',  GenderHelper::getL10nList( ), '', 'gender' );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPL_COUNTRY_LIST' => $countryList,
                       'TPL_CONTRACT_LIST' => $contractList,
                       'TPL_DESIGNATION_LIST' => $designationList,
                       'TPL_GENDER_RADIO' => $genderRadio ) );

        $vars['dynamic']['noGroup'] = false;

        if( isset( $output['groupList'] ) ) {
            $vars['TPL_GROUP_TREE_LIST'] = $output['groupList'];
        }
        return $this->render( 'markaxis/payroll/taxes.tpl', $vars );
    }
}
?>