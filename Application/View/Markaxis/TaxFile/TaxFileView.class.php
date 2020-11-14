<?php
namespace Markaxis\TaxFile;
use \Markaxis\Employee\EmployeeModel;
use \Markaxis\Company\CompanyModel, \Library\Helper\Markaxis\IrasExemptHelper;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView, \Aurora\Form\RadioView;
use \Aurora\Form\DayIntListView, \Aurora\Component\NationalityModel;
use \Aurora\Component\OfficeModel, \Aurora\Component\DesignationModel;
use \Library\Helper\Aurora\YesNoHelper;
use \Library\Helper\Markaxis\SourceTypeHelper, \Library\Helper\Markaxis\OrgTypeHelper;
use \Library\Helper\Markaxis\IrasPaymentTypeHelper;
use \Library\Helper\Aurora\MonthHelper, \Library\Helper\Aurora\GenderHelper;
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
    protected $PayrollRes;
    protected $TaxFileRes;
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
        $this->TaxFileRes = $this->i18n->loadLanguage('Markaxis/TaxFile/TaxFileRes');
        $this->PayrollRes = $this->i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->TaxFileModel = TaxFileModel::getInstance( );

        $this->View->setJScript( array( 'plugins/moment' => 'moment.min.js',
                                        'plugins/tables/datatables' => array( 'datatables.min.js', 'datatables.pipeline.js', 'checkboxes.min.js'),
                                        'plugins/forms' => array( 'wizards/stepy.min.js', 'tags/tokenfield.min.js', 'input/typeahead.bundle.min.js' ),
                                        'plugins/buttons' => array( 'spin.min.js', 'ladda.min.js' ),
                                        'plugins/pickers' => array( 'picker.js', 'picker.date.js', 'daterangepicker.js' ),
                                        'jquery' => array( 'mark.min.js', 'jquery.validate.min.js' ),
                                        'markaxis' => 'taxfile.js',
                                        'locale' => array( $this->TaxFileRes->getL10n( ), $this->PayrollRes->getL10n( ) ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderTaxFile( ) {
        $vars = array( );

        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'icon-coins',
                                            'text' => $this->TaxFileRes->getContents('LANG_TAX_FILING') ) );

        $vars = array_merge( $this->TaxFileRes->getContents( ), $vars );
        $this->View->printAll( $this->View->render( 'markaxis/taxfile/taxFile.tpl', $vars ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderTaxFileForm( $tfID ) {
        $year = date('Y');

        if( $tfID ) {
            $tfInfo = $this->TaxFileModel->getByTFID( $tfID );

            if( isset( $tfInfo['fileYear'] ) ) {
                $year = $tfInfo['fileYear'];
            }
        }

        $SelectListView = new SelectListView( );

        $OfficeModel = OfficeModel::getInstance( );
        $office = $OfficeModel->getList( );
        $officeList = $SelectListView->build( 'office',  $office, key( $office ), 'Select Office / Location' );

        $currYear = date('Y', strtotime('-0 year') );
        $prevYear = date('Y', strtotime('-3 year') );
        $yearList = array( );
        $selected = '';

        for( $i=$currYear; $i>=$prevYear; $i-- ) {
            $yearList[$i] = $i;

            if( $i == $year ) {
                $selected = $i;
            }
        }

        $tfID = 0;
        if( $tfInfo = $this->TaxFileModel->getByFileYear( $selected, 'O' ) ) {
            $tfID = $tfInfo['tfID'];
        }

        $yearList = $SelectListView->build( 'year',  $yearList, $selected, 'Select Year' );

        $sourceType = isset( $tfInfo['sourceType'] ) ? $tfInfo['sourceType'] : 6;
        $sourceTypeList = $SelectListView->build( 'sourceType', SourceTypeHelper::getL10nList( ),$sourceType, $this->TaxFileRes->getContents('LANG_SELECT_SOURCE_TYPE') );

        $orgIDType = isset( $tfInfo['$orgIDType'] ) ? $tfInfo['$orgIDType'] : 8;
        $orgIDTypeList = $SelectListView->build( 'orgIDType', OrgTypeHelper::getL10nList( ),$orgIDType, $this->TaxFileRes->getContents('LANG_ORGANISATION_ID_TYPE') );
        $paymentTypeList = $SelectListView->build( 'paymentType', IrasPaymentTypeHelper::getL10nList( ),'08', $this->TaxFileRes->getContents('LANG_SELECT_PAYMENT_TYPE') );

        $RadioView = new RadioView( );
        $batchOption = array( 'O' => 'Original', 'A' => 'Amendment' );
        $batch = isset( $tfInfo['batch'] ) ? $tfInfo['batch'] : 'O';
        $batchRadio = $RadioView->build('batch', $batchOption, $batch );

        $CompanyModel = CompanyModel::getInstance( );
        $companyInfo = $CompanyModel->loadInfo( );

        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

        $EmployeeModel = EmployeeModel::getInstance( );
        $empInfo = $EmployeeModel->getIR8AInfo( $userInfo['userID'] );

        $vars = array_merge( $this->TaxFileRes->getContents( ), $this->PayrollRes->getContents( ),
                array( 'TPLVAR_TAXFILE_ID' => $tfID,
                       'TPLVAR_REG_NUMBER' => $companyInfo['regNumber'],
                       'TPLVAR_COMPANY_NAME' => $companyInfo['name'],
                       'TPLVAR_NAME' => $empInfo['name'],
                       'TPLVAR_DESIGNATION' => $empInfo['designation'],
                       'TPLVAR_MOBILE' => $empInfo['mobile'],
                       'TPLVAR_EMAIL' => $empInfo['email'],
                       'TPL_YEAR_LIST' => $yearList,
                       'TPL_OFFICE_LIST' => $officeList,
                       'TPL_SOURCE_TYPE_LIST' => $sourceTypeList,
                       'TPL_ORG_ID_LIST' => $orgIDTypeList,
                       'TPL_PAYMENT_TYPE_LIST' => $paymentTypeList,
                       'TPL_BATCH_RADIO' => $batchRadio ) );

        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'icon-coins',
                                            'text' => $this->TaxFileRes->getContents('LANG_TAX_FILING') ) );

        $this->View->setJScript( array( 'markaxis' => array( 'taxFileEmployee.js', 'taxFileDeclare.js' ) ) );

        $this->View->printAll( $this->View->render( 'markaxis/taxfile/taxFileForm.tpl', $vars ) );
    }


     /**
     * Render main navigation
     * @return string
     */
     public function renderIr8aForm( $tfID, $userID ) {
         $CompanyModel = CompanyModel::getInstance( );
         $companyInfo = $CompanyModel->loadInfo( );

         $EmployeeModel = EmployeeModel::getInstance( );
         $empInfo = $EmployeeModel->getIR8AInfo( $userID );

         $DesignationModel = DesignationModel::getInstance( );

         $dobDay = $dobMonth = $dobYear = '';
         if( $empInfo['birthday'] ) {
             $birthday = explode( '-', $empInfo['birthday'] );
             $dobDay   = $birthday[2];
             $dobMonth = $birthday[1];
             $dobYear  = $birthday[0];
         }
         $DayIntListView = new DayIntListView( );
         $SelectListView = new SelectListView( );
         $dobDayList   = $DayIntListView->getList('dobDay', $dobDay, 'Day' );
         $dobMonthList = $SelectListView->build('dobMonth', MonthHelper::getL10nList( ), $dobMonth, 'Month' );

         $NationalityModel = NationalityModel::getInstance( );
         $nationalities = $NationalityModel->getList( );
         $nationalityList = $SelectListView->build( 'nationality', $nationalities,$empInfo['nationalityID'],'Select Nationality' );

         $RadioView = new RadioView( );
         $genderRadio = $RadioView->build('gender', GenderHelper::getL10nList( ), $empInfo['gender'] );

         $IR8AModel = IR8AModel::getInstance( );
         $ir8aInfo = $IR8AModel->getByUserIDTFID( $userID, $tfID );

         $startDay = $startMonth = $startYear = '';
         if( $ir8aInfo['empStartDate'] ) {
             $startDate = explode( '-', $ir8aInfo['empStartDate'] );
             $startDay   = $startDate[2];
             $startMonth = $startDate[1];
             $startYear  = $startDate[0];
         }

         $SelectListView->isDisabled(true);
         $DayIntListView->isDisabled(true);
         $startDayList   = $DayIntListView->getList('startDay', $startDay, 'Day' );
         $startMonthList = $SelectListView->build('startMonth', MonthHelper::getL10nList( ), $startMonth, 'Month' );

         $endDay = $endMonth = $endYear = '';
         if( $ir8aInfo['empEndDate'] ) {
             $endDate = explode( '-', $ir8aInfo['empEndDate'] );
             $endDay   = $endDate[2];
             $endMonth = $endDate[1];
             $endYear  = $endDate[0];
         }
         $endDayList   = $DayIntListView->getList('endDay', $endDay, 'Day' );
         $endMonthList = $SelectListView->build('endMonth', MonthHelper::getL10nList( ), $endMonth, 'Month' );

         $commFromDay = $commFromMonth = $commFromYear =
         $commToDay = $commToMonth = $commToYear = '';
         if( $ir8aInfo['grossCommFromDate'] ) {
             $grossCommFromDate = explode( '-', $ir8aInfo['grossCommFromDate'] );
             $commFromDay   = $grossCommFromDate[2];
             $commFromMonth = $grossCommFromDate[1];
             $commFromYear  = $grossCommFromDate[0];
         }
         $commFromDayList   = $DayIntListView->getList('commFromDay', $commFromDay, 'Day' );
         $commFromMonthList = $SelectListView->build('commFromMonth', MonthHelper::getL10nList( ), $commFromMonth, 'Month' );

         if( $ir8aInfo['grossCommToDate'] ) {
             $grossCommToDate = explode( '-', $ir8aInfo['grossCommToDate'] );
             $commToDay   = $grossCommToDate[2];
             $commToMonth = $grossCommToDate[1];
             $commToYear  = $grossCommToDate[0];
         }
         $commToDayList   = $DayIntListView->getList('commToDay', $commToDay, 'Day' );
         $commToMonthList = $SelectListView->build('commToMonth', MonthHelper::getL10nList( ), $commToMonth, 'Month' );

         $commType = array( 0 => 'Monthly Payment', 1 => 'Adhoc Payment' );
         $commPaymentTypeRadio = $RadioView->build('commPaymentType', $commType, $ir8aInfo['commType'] );
         $irasApprovedRadio = $RadioView->build('approveIRAS', YesNoHelper::getL10nList( ), $ir8aInfo['approveIRAS'] );
         $contriMandRadio = $RadioView->build('overseasContriMand', YesNoHelper::getL10nList( ), $ir8aInfo['overseasContriMand'] );
         $contributionChargedRadio = $RadioView->build('contributionCharged', YesNoHelper::getL10nList( ), $ir8aInfo['contributionCharged'] );
         $taxBorneRadio = $RadioView->build('taxBorne', YesNoHelper::getL10nList( ), $ir8aInfo['taxBorne'] );

         $approvedDay = $approvedMonth = $approvedYear = '';
         if( $ir8aInfo['approveDate'] ) {
             $approvedDate = explode( '-', $ir8aInfo['approveDate'] );
             $approvedDay   = $approvedDate[2];
             $approvedMonth = $approvedDate[1];
             $approvedYear  = $approvedDate[0];
         }

         $SelectListView->isDisabled(false);
         $DayIntListView->isDisabled(false);
         $approvedDayList   = $DayIntListView->getList('approvedDay', $approvedDay, 'Day' );
         $approvedMonthList = $SelectListView->build('approvedMonth', MonthHelper::getL10nList( ), $approvedMonth, 'Month' );
         $exemptIndicator   = $SelectListView->build('exemptIndicator', IrasExemptHelper::getL10nList( ), $ir8aInfo['exemptIndicator'], 'Select Exempt Indicator' );

         $designation = '';
         if( $dInfo = $DesignationModel->getByID( $empInfo['designationID'] ) ) {
             $designation = $dInfo['title'];
         }

         $vars = array( 'TPLVAR_USERID' => $userID,
                         'TPLVAR_TFID' => $tfID,
                         'TPLVAR_YEAR' => ($ir8aInfo['fileYear']-1),
                         'TPLVAR_EMP_REF' => $companyInfo['regNumber'],
                         'TPLVAR_EMP_ID' => $empInfo['nric'],
                         'TPLVAR_EMP_NAME' =>  $empInfo['name'],
                         'TPL_DOB_MONTH_LIST' => $dobMonthList,
                         'TPL_DOB_DAY_LIST' => $dobDayList,
                         'TPLVAR_DOB_YEAR' => $dobYear,
                         'TPL_START_MONTH_LIST' => $startMonthList,
                         'TPL_START_DAY_LIST' => $startDayList,
                         'TPLVAR_START_YEAR' => $startYear,
                         'TPL_END_MONTH_LIST' => $endMonthList,
                         'TPL_END_DAY_LIST' => $endDayList,
                         'TPLVAR_END_YEAR' => $endYear,
                         'TPL_NATIONALITY_LIST' => $nationalityList,
                         'TPL_GENDER_RADIO' => $genderRadio,
                         'TPLVAR_DESIGNATION' => $designation,
                         'TPLVAR_ADDRESS' => $empInfo['houseNo'] . ' ' . $empInfo['streetName'] . ' ' . $empInfo['levelUnit'],
                         'TPLVAR_BANK_NAME' => $empInfo['bankName'],
                         'TPLVAR_SALARY' => $ir8aInfo['gross'],
                         'TPLVAR_BONUS' => $ir8aInfo['bonus'],
                         'TPLVAR_DIRECTOR_FEES' => $ir8aInfo['directorFee'],
                         'TPLVAR_TRANSPORT' => $ir8aInfo['transport'],
                         'TPLVAR_ENTERTAINMENT' => $ir8aInfo['entertainment'],
                         'TPLVAR_OTHER_ALLOWANCE' => $ir8aInfo['others'],
                         'TPL_COMM_FROM_MONTH_LIST' => $commFromMonthList,
                         'TPL_COMM_FROM_DAY_LIST' => $commFromDayList,
                         'TPLVAR_COMM_FROM_YEAR' => $commFromYear,
                         'TPL_COMM_TO_MONTH_LIST' => $commToMonthList,
                         'TPL_COMM_TO_DAY_LIST' => $commToDayList,
                         'TPLVAR_COMM_TO_YEAR' => $commToYear,
                         'TPL_COMM_PAYMENT_TYPE' => $commPaymentTypeRadio,
                         'TPLVAR_TOTAL_COMM' => $ir8aInfo['totalComm'],
                         'TPLVAR_GRATUITY' => $ir8aInfo['gratuity'],
                         'TPLVAR_NOTICE_PAY' => $ir8aInfo['noticePay'],
                         'TPLVAR_EX_GRATIA' => $ir8aInfo['exGratia'],
                         'TPLVAR_OTHER_LUMP_SUM' => $ir8aInfo['otherLumpSum'],
                         'TPLVAR_OTHER_LUMP_SUM_REMARK' => $ir8aInfo['otherLumpSumRemark'],
                         'TPLVAR_COMPENSATION' => $ir8aInfo['compensation'],
                         'TPL_IRAS_APPROVED_RADIO' => $irasApprovedRadio,
                         'TPL_APPROVED_MONTH_LIST' => $approvedMonthList,
                         'TPL_APPROVED_DAY_LIST' => $approvedDayList,
                         'TPLVAR_APPROVED_YEAR' => $approvedYear,
                         'TPLVAR_REASON_PAYMENT' => $ir8aInfo['reasonPayment'],
                         'TPLVAR_LENGTH_SERVICE' => $ir8aInfo['lengthService'],
                         'TPLVAR_BASIS_PAYMENT' => $ir8aInfo['basisPayment'],
                         'TPLVAR_RETIRE_FUND_NAME' => $ir8aInfo['retireFundName'],
                         'TPLVAR_ACCRUED92' => $ir8aInfo['amtAccrued92'],
                         'TPLVAR_ACCRUED93' => $ir8aInfo['amtAccrued93'],
                         'TPLVAR_CONTRI_WITHOUT_TAX' => $ir8aInfo['contriOutSGWithoutTax'],
                         'TPLVAR_OVERSEAS_FUND_NAME' => $ir8aInfo['overseasFundName'],
                         'TPLVAR_OVERSEAS_FUND_AMT' => $ir8aInfo['overseasFundAmt'],
                         'TPL_CONTRI_MAND_RADIO' => $contriMandRadio,
                         'TPL_CONTRI_CHARGED_RADIO' => $contributionChargedRadio,
                         'TPLVAR_EXCESS_CONTRI' => $ir8aInfo['excessContriByEmployer'],
                         'TPLVAR_GAINS_PROFIT' => $ir8aInfo['gainsProfitESOP'],
                         'TPLVAR_BENEFITS_IN_KIND' => $ir8aInfo['benefitsInKind'],
                         'TPL_EXEMPT_INDICATOR' => $exemptIndicator,
                         'TPLVAR_EXEMPT_INCOME' => $ir8aInfo['exemptIncome'],
                         'TPL_TAX_BORNE_RADIO' => $taxBorneRadio,
                         'TPLVAR_EMP_TAX_BORNE' => $ir8aInfo['employerTaxBorne'],
                         'TPLVAR_EMP_TAX_PAID' => $ir8aInfo['empTaxPaid'],
                         'TPLVAR_DEDUCT_FUND_NAME' => $ir8aInfo['deductFundName'],
                         'TPLVAR_CPF' => $ir8aInfo['cpf'],
                         'TPLVAR_DONATIONS' => $ir8aInfo['donation'],
                         'TPLVAR_CONTRI_MOSQUE' => $ir8aInfo['contriMosque'],
                         'TPLVAR_INSURANCE' => $ir8aInfo['insurance']
                     );
         return $this->View->render( 'markaxis/taxfile/ir8aForm.tpl', $vars );
     }


    /**
     * Render main navigation
     * @return string
     */
    public function renderA8aForm( $tfID, $userID ) {
        $IRA8AModel = IRA8AModel::getInstance( );
        $ira8aInfo = $IRA8AModel->getByUserIDTFID( $userID, $tfID, true );

        $EmployeeModel = EmployeeModel::getInstance( );
        $empInfo = $EmployeeModel->getIR8AInfo( $userID );

        $DayIntListView = new DayIntListView( );
        $SelectListView = new SelectListView( );

        $fromDay = $fromMonth = $fromYear = $toDay = $toMonth = $toYear = '';

        if( isset( $ira8aInfo['periodFrom'] ) ) {
            $periodFrom = explode( '-', $ira8aInfo['periodFrom'] );
            $fromDay   = $periodFrom[2];
            $fromMonth = $periodFrom[1];
            $fromYear  = $periodFrom[0];
        }

        $fromDayList   = $DayIntListView->getList('fromDay', $fromDay, 'Day' );
        $fromMonthList = $SelectListView->build('fromMonth', MonthHelper::getL10nList( ), $fromMonth, 'Month' );

        if( isset( $ira8aInfo['periodTo'] ) ) {
            $periodTo = explode( '-', $ira8aInfo['periodTo'] );
            $toDay   = $periodTo[2];
            $toMonth = $periodTo[1];
            $toYear  = $periodTo[0];
        }

        $toDayList   = $DayIntListView->getList('toDay', $toDay, 'Day' );
        $toMonthList = $SelectListView->build('toMonth', MonthHelper::getL10nList( ), $toMonth, 'Month' );

        $furnitureIndType = array( 'P' => 'Partially Furnished', 'F' => 'Fully Furnished' );
        $furnitureInd = '';

        if( isset( $ira8aInfo['furnitureInd'] ) ) {
            $furnitureInd = $ira8aInfo['furnitureInd'];
        }

        $RadioView = new RadioView( );
        $furnitureIndicator = $RadioView->build('furnitureInd', $furnitureIndType, $furnitureInd );

        $vars = array( 'TPLVAR_USERID' => $userID,
                       'TPLVAR_TFID' => $tfID,
                       'TPLVAR_EMP_ID' => $empInfo['nric'],
                       'TPLVAR_EMP_NAME' =>  $empInfo['name'],
                       'TPLVAR_ADDRESS' => isset( $ira8aInfo['empAddress'] ) ? $ira8aInfo['empAddress'] : $empInfo['houseNo'] . ' ' . $empInfo['streetName'] . ' ' . $empInfo['levelUnit'] . ' ' . $empInfo['postal'],
                       'TPLVAR_DAYS' => $ira8aInfo['days'],
                       'TPLVAR_NUMBER_SHARE' => $ira8aInfo['numberShare'],
                       'TPLVAR_ANNUAL_VALUE' => $ira8aInfo['annualValue'],
                       'TPLVAR_FURNITURE_VALUE' => $ira8aInfo['furnitureValue'],
                       'TPL_FURNITURE_IND_RADIO' => $furnitureIndicator,
                       'TPLVAR_RENT_PAID_EMPLOYER' => $ira8aInfo['rentPaidEmployer'],
                       'TPLVAR_TAXABLE_VALUE' => $ira8aInfo['taxableValue'],
                       'TPLVAR_RENT_PAID_EMPLOYEE' => $ira8aInfo['rentPaidEmployee'],
                       'TPLVAR_TOTAL_TAXABLE_PLACE' => $ira8aInfo['totalTaxablePlace'],
                       'TPLVAR_UTILITIES' => $ira8aInfo['utilities'],
                       'TPLVAR_DRIVER' => $ira8aInfo['driver'],
                       'TPLVAR_UPKEEP' => $ira8aInfo['upkeep'],
                       'TPLVAR_TOTAL_UTILITIES' => $ira8aInfo['totalTaxableUtilities'],
                       'TPLVAR_HOTEL' => $ira8aInfo['hotel'],
                       'TPLVAR_HOTEL_PAID_EMPLOYEE' => $ira8aInfo['hotelPaidEmployee'],
                       'TPLVAR_HOTEL_TOTAL' => $ira8aInfo['hotelTotal'],
                       'TPLVAR_INCIDENTAL_BENEFITS' => $ira8aInfo['incidentalBenefits'],
                       'TPLVAR_INTEREST_PAYMENT' => $ira8aInfo['interestPayment'],
                       'TPLVAR_INSURANCE' => $ira8aInfo['insurance'],
                       'TPLVAR_HOLIDAYS' => $ira8aInfo['holidays'],
                       'TPLVAR_EDUCATION' => $ira8aInfo['education'],
                       'TPLVAR_RECREATION' => $ira8aInfo['recreation'],
                       'TPLVAR_ASSET_GAIN' => $ira8aInfo['assetGain'],
                       'TPLVAR_VEHICLE_GAIN' => $ira8aInfo['vehicleGain'],
                       'TPLVAR_CAR_BENEFITS' => $ira8aInfo['carBenefits'],
                       'TPLVAR_OTHER_BENEFITS' => $ira8aInfo['otherBenefits'],
                       'TPL_FROM_MONTH_LIST' => $fromMonthList,
                       'TPL_FROM_DAY_LIST' => $fromDayList,
                       'TPLVAR_FROM_YEAR' => $fromYear,
                       'TPL_TO_MONTH_LIST' => $toMonthList,
                       'TPL_TO_DAY_LIST' => $toDayList,
                       'TPLVAR_TO_YEAR' => $toYear,
                       'TPLVAR_TOTAL_BENEFITS' => $ira8aInfo['totalBenefits']
        );
        return $this->View->render( 'markaxis/taxfile/ira8aForm.tpl', $vars );
    }
}
?>