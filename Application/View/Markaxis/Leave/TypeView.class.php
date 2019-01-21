<?php
namespace Markaxis\Leave;
use \Aurora\AuroraView, \Aurora\Form\RadioView, \Aurora\Form\SelectListView, \Markaxis\Form\DesignationListView;
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

class TypeView extends AuroraView {


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
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Leave/LeaveRes');

        $this->TypeModel = TypeModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderSettings( ) {
        $vars = array_merge( $this->L10n->getContents( ),
                array( ) );

        return $this->render( 'markaxis/leave/type.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderAddType( ) {
        $this->info = $this->TypeModel->getInfo( );
        return $this->renderForm( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderEditType( $ltID ) {
        if( $this->info = $this->TypeModel->getByID( $ltID ) ) {
            return $this->renderForm( );
        }
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderForm( ) {
        $RadioView = new RadioView( );
        $proRated = $RadioView->build( 'proRated', ProRatedHelper::getL10nList( ), $this->info['proRated'] );
        $allowHalfDayRadio = $RadioView->build( 'allowHalfDay', HalfDayHelper::getL10nList( ), $this->info['allowHalfDay'] );
        $paidLeave = $RadioView->build( 'paidLeave', PaidLeaveHelper::getL10nList( ), $this->info['paidLeave'] );
        $childCare = $RadioView->build( 'childCare', YesNoHelper::getL10nList( ), 0 );

        $SelectListView = new SelectListView( );

        $appliedList = $SelectListView->build( 'applied', AppliedHelper::getL10nList( ), $this->info['applied'] );
        $unusedList  = $SelectListView->build( 'unused', UnusedLeaveHelper::getL10nList( ), $this->info['unused'] );

        $SelectListView->isDisabled( true );
        $pPeriodList = $SelectListView->build( 'pPeriodType', LeavePeriodHelper::getL10nList( ), $this->info['pPeriodType'], $this->L10n->getContents('LANG_SELECT_PERIOD') );
        $cPeriodList = $SelectListView->build( 'cPeriodType', CarryPeriodHelper::getL10nList( ), $this->info['cPeriodType'], $this->L10n->getContents('LANG_SELECT_PERIOD') );
        $usedPeriodList  = $SelectListView->build( 'usedType', LeavePeriodHelper::getL10nList( ), $this->info['uPeriodType'], $this->L10n->getContents('LANG_SELECT_PERIOD') );

        $SelectListView->isDisabled( false );
        $SelectListView->isMultiple( true );
        $SelectListView->includeBlank( false );
        $gender = $this->info['gender'] == 'all' ? $this->info['gender'] : explode(',', $this->info['gender'] );
        $genderList = $SelectListView->build( 'gender', GenderHelper::getL10nList( ), $gender );

        $SelectGroupListView = new DesignationListView( );
        $SelectGroupListView->isMultiple( true );

        $DesignationModel = DesignationModel::getInstance( );
        $designation = $this->info['designation'] == 'all' ? $this->info['designation'] : explode(',', $this->info['designation'] );
        $designationList = $SelectGroupListView->build( 'designation', $DesignationModel->getList( ), $designation );

        $ContractModel = ContractModel::getInstance( );
        $contract = $this->info['contract'] == 'all' ? $this->info['contract'] : explode(',', $this->info['contract'] );

        $contractList = $SelectListView->build( 'contractType',  $ContractModel->getList( ), $contract );
        //$childrenList = $SelectListView->build( 'haveChild', YesNoHelper::getL10nList( ), $this->info['haveChild'] );
        $childrenList = $RadioView->build( 'haveChild', YesNoHelper::getL10nList( ), $this->info['haveChild'] );

        $OfficeModel = OfficeModel::getInstance( );
        $office = $this->info['office'] == 'all' ? $this->info['office'] : explode(',', $this->info['office'] );
        $officeList = $SelectListView->build( 'office',  $OfficeModel->getList( ), $office );

        $CountryModel = CountryModel::getInstance( );
        $countries = $CountryModel->getList( );

        $SelectListView = new SelectListView( );
        $childCountryList = $SelectListView->build( 'childBorn', $countries, $this->info['childBorn'], 'Select a Country' );

        $maxAge = 10;
        $ageList = array( );

        for( $i=1; $i<=$maxAge; $i++ ) {
            $ageList[$i] = $i;
        }
        $childAgeList = $SelectListView->build( 'childAge', $ageList, $this->info['childAge'], 'Select Maximum Age' );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_LEAVE_TYPE_NAME' => $this->info['name'],
                       'TPLVAR_LEAVE_TYPE_CODE' => $this->info['code'],
                       'TPLVAR_PPERIOD' => $this->info['pPeriod'],
                       'TPLVAR_CPERIOD' => $this->info['cPeriod'],
                       'TPLVAR_UPERIOD' => $this->info['uPeriod'],
                       'TPL_PRO_RATED_RADIO' => $proRated,
                       'TPL_ALLOW_HALF_DAY_RADIO' => $allowHalfDayRadio,
                       'TPL_CHILD_CARE_RADIO' => $childCare,
                       'TPL_PAID_LEAVE' => $paidLeave,
                       'TPL_APPLIED_LIST' => $appliedList,
                       'TPL_UNUSED_LIST' => $unusedList,
                       'TPL_PPERIOD_LIST' => $pPeriodList,
                       'TPL_CPERIOD_LIST' => $cPeriodList,
                       'TPL_USED_PERIOD_LIST' => $usedPeriodList,
                       'TPL_GENDER_LIST' => $genderList,
                       'TPL_OFFICE_LIST' => $officeList,
                       'TPL_DESIGNATION_LIST' => $designationList,
                       'TPL_CONTRACT_LIST' => $contractList,
                       'TPL_CHILDREN_LIST' => $childrenList,
                       'TPL_CHILD_COUNTRY_LIST' => $childCountryList,
                       'TPL_CHILD_AGE_LIST' => $childAgeList ) );

        return $this->render( 'markaxis/leave/typeForm.tpl', $vars );
    }
}
?>