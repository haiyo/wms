<?php
namespace Markaxis\Leave;
use \Aurora\Admin\AdminView, \Aurora\Form\RadioView, \Aurora\Form\SelectListView, \Markaxis\Form\DesignationListView;
use \Library\Helper\Aurora\GenderHelper, \Aurora\Component\DesignationModel, \Aurora\Component\ContractModel;
use \Library\Helper\Aurora\YesNoHelper, \Aurora\Component\CountryModel, \Aurora\Component\OfficeModel;
use \Library\Helper\Markaxis\ProRatedHelper, \Library\Helper\Markaxis\HalfDayHelper, \Library\Helper\Markaxis\PaidLeaveHelper;
use \Library\Helper\Markaxis\AppliedHelper, \Library\Helper\Markaxis\UnusedLeaveHelper;
use \Library\Helper\Markaxis\LeavePeriodHelper, \Library\Helper\Markaxis\CarryPeriodHelper;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: TypeView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TypeView extends AdminView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $TypeModel;


    /**
    * TypeView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Leave/LeaveRes');

        $this->TypeModel = TypeModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSettings( ) {
        $vars = array_merge( $this->L10n->getContents( ),
                array( ) );

        return $this->View->render( 'markaxis/leave/typeList.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderAddType( ) {
        $this->info = $this->TypeModel->getInfo( );
        return $this->renderForm( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderEditType( $ltID ) {
        if( $this->info = $this->TypeModel->getByID( $ltID ) ) {
            return $this->renderForm( );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderForm( ) {
        $RadioView = new RadioView( );
        $proRated = $RadioView->build( 'proRated', ProRatedHelper::getL10nList( ), $this->info['proRated'] );
        $allowHalfDayRadio = $RadioView->build( 'allowHalfDay', HalfDayHelper::getL10nList( ), $this->info['allowHalfDay'] );
        //$paidLeave = $RadioView->build( 'paidLeave', PaidLeaveHelper::getL10nList( ), $this->info['paidLeave'] );

        $SelectListView = new SelectListView( );
        $paidLeaveList  = $SelectListView->build( 'paidLeave', PaidLeaveHelper::getL10nList( ), $this->info['paidLeave'] );
        $appliedList    = $SelectListView->build( 'applied', AppliedHelper::getL10nList( ), $this->info['applied'] );
        $unusedList     = $SelectListView->build( 'unused', UnusedLeaveHelper::getL10nList( ), $this->info['unused'] );

        $SelectListView->isDisabled( true );
        $pPeriodList = $SelectListView->build( 'pPeriodType', LeavePeriodHelper::getL10nList( ), $this->info['pPeriodType'], $this->L10n->getContents('LANG_SELECT_PERIOD') );
        $cPeriodList = $SelectListView->build( 'cPeriodType', CarryPeriodHelper::getL10nList( ), $this->info['cPeriodType'], $this->L10n->getContents('LANG_SELECT_PERIOD') );
        $usedPeriodList  = $SelectListView->build( 'usedType', LeavePeriodHelper::getL10nList( ), $this->info['uPeriodType'], $this->L10n->getContents('LANG_SELECT_PERIOD') );

        $SelectGroupListView = new DesignationListView( );
        $SelectGroupListView->isMultiple( true );

        $childrenList = $RadioView->build( 'haveChild', YesNoHelper::getL10nList( ), $this->info['haveChild'] );

        $CountryModel = CountryModel::getInstance( );
        $countries = $CountryModel->getList( );

        $SelectListView = new SelectListView( );
        $childCountryList = $SelectListView->build( 'childBorn', $countries, $this->info['childBorn'], 'Select a Country' );

        $maxAge = 10;
        $ageList = array( );

        for( $i=1; $i<=$maxAge; $i++ ) {
            $ageList[$i] = $i;
        }
        $childAgeList = $SelectListView->build( 'childAge', $ageList, $this->info['childAge'], 'Select Child Age' );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_LEAVE_TYPE_NAME' => $this->info['name'],
                       'TPLVAR_LEAVE_TYPE_CODE' => $this->info['code'],
                       'TPLVAR_PPERIOD' => $this->info['pPeriod'],
                       'TPLVAR_CPERIOD' => $this->info['cPeriod'],
                       'TPLVAR_UPERIOD' => $this->info['uPeriod'],
                       'TPLVAR_PAYROLL_FORMULA' => '',
                       'TPL_PRO_RATED_RADIO' => $proRated,
                       'TPL_ALLOW_HALF_DAY_RADIO' => $allowHalfDayRadio,
                       'TPL_PAID_LEAVE' => $paidLeaveList,
                       'TPL_APPLIED_LIST' => $appliedList,
                       'TPL_UNUSED_LIST' => $unusedList,
                       'TPL_PPERIOD_LIST' => $pPeriodList,
                       'TPL_CPERIOD_LIST' => $cPeriodList,
                       'TPL_USED_PERIOD_LIST' => $usedPeriodList,
                       'TPL_CHILDREN_LIST' => $childrenList,
                       'TPL_CHILD_COUNTRY_LIST' => $childCountryList,
                       'TPL_CHILD_AGE_LIST' => $childAgeList ) );

        return $this->View->render( 'markaxis/leave/typeForm.tpl', $vars );
    }
}
?>