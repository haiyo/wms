<?php
namespace Markaxis\Company;
use \Aurora\Component\CountryModel, \Aurora\Form\SelectListView;
use \Library\Runtime\Registry, \Aurora\Admin\AdminView;
use \Library\Helper\Aurora\DayHelper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: OfficeView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class OfficeView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $OfficeModel;
    protected $info;


    /**
    * OfficeView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Company/OfficeRes');

        $this->OfficeModel = OfficeModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderSettings( ) {
        $SelectListView = new SelectListView( );
        $CountryModel = CountryModel::getInstance( );
        $countries = $CountryModel->getList( );
        $countryList = $SelectListView->build( 'officeCountry', $countries, '', 'Select Country' );

        $OfficeTypeModel = OfficeTypeModel::getInstance( );
        $officeTypeList  = $SelectListView->build( 'officeType', $OfficeTypeModel->getList( ), '', 'Select Office Type' );

        $nList = DayHelper::getL10nNumericValueList( );
        $workDayToList   = $SelectListView->build( 'workDayTo', $nList, '', 'Select Work Day To' );
        $SelectListView->isDisabled(true);
        $workDayFromList = $SelectListView->build( 'workDayFrom', $nList, '', 'Select Work Day From' );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_HREF' => 'officeList',
                       'LANG_TEXT' => $this->L10n->getContents( 'LANG_OFFICE' ),
                       'TPL_COUNTRY_LIST' => $countryList,
                       'TPL_OFFICE_TYPE_LIST' => $officeTypeList,
                       'TPL_WORK_DAY_FROM' => $workDayFromList,
                       'TPL_WORK_DAY_TO' => $workDayToList ) );

        return array( 'tab'  => $this->View->render( 'aurora/core/tab.tpl', $vars ),
                      'form' => $this->View->render( 'markaxis/company/officeList.tpl', $vars ) );
    }
}
?>