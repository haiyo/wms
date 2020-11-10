<?php
namespace Markaxis\TaxFile;
use \Markaxis\Employee\EmployeeModel;
use \Markaxis\Company\CompanyModel;
use \Markaxis\Payroll\UserItemModel;
use \Markaxis\Payroll\UserTaxModel;
use \Aurora\Admin\AdminView;
use \Library\Helper\Markaxis\IRASCountryCodeHelper;
use \Library\Util\Date;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: IRA8AView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class IRA8AView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $PayrollRes;
    protected $TaxFileRes;
    protected $View;
    protected $IR8AModel;


    /**
    * IRA8AView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->TaxFileRes = $this->i18n->loadLanguage('Markaxis/TaxFile/TaxFileRes');
        $this->PayrollRes = $this->i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->IRA8AModel = IRA8AModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderXML( $tfID, $readonly=false ) {
        $TaxFileModel = TaxFileModel::getInstance( );
        $tfInfo = $TaxFileModel->getByTFID( $tfID );
        $ira8aInfo = $this->IRA8AModel->getByTFID( $tfID );

        if( $tfInfo && $ira8aInfo ) {
            $xml = '<?xml version="1.0" encoding="utf-8" standalone="no"?>
<A8A2015 xmlns="http://www.iras.gov.sg/A8A2015Def">
<A8AHeader>
<ESubmissionSDSC xmlns="http://tempuri.org/ESubmissionSDSC.xsd">
<FileHeaderST>
<RecordType>0</RecordType>
<Source>' . $tfInfo['sourceType'] . '</Source>
<BasisYear>' . $tfInfo['fileYear'] . '</BasisYear>
<OrganizationID>' . $tfInfo['orgIDType'] . '</OrganizationID>
<OrganizationIDNo>' . $tfInfo['regNumber'] . '</OrganizationIDNo>
<AuthorisedPersonName>' . $tfInfo['authName'] . '</AuthorisedPersonName>
<AuthorisedPersonDesignation>' . $tfInfo['authDesignation'] . '</AuthorisedPersonDesignation>
<EmployerName>' . $tfInfo['companyName'] . '</EmployerName>
<Telephone>' . $tfInfo['authPhone'] . '</Telephone>
<AuthorisedPersonEmail>' . $tfInfo['authEmail'] . '</AuthorisedPersonEmail>
<BatchIndicator>' . $tfInfo['batch'] . '</BatchIndicator>
<BatchDate>' . date('Ymd', strtotime( $tfInfo['created'] ) ) . '</BatchDate>
<DivisionOrBranchName/>
</FileHeaderST>
</ESubmissionSDSC>
</A8AHeader>
<Details>';

            foreach( $ira8aInfo as $info ) {
                $annualValue = $info['annualValue'] > 0 ? $info['annualValue'] : '';
                $furnitureValue = $info['furnitureValue'] > 0 ? $info['furnitureValue'] : '';
                $rentPaidEmployer = $info['rentPaidEmployer'] > 0 ? $info['rentPaidEmployer'] : '';
                $taxableValue = $info['taxableValue'] > 0 ? $info['taxableValue'] : '';
                $rentPaidEmployee = $info['rentPaidEmployee'] > 0 ? $info['rentPaidEmployee'] : '';
                $totalTaxablePlace = $info['totalTaxablePlace'] > 0 ? $info['totalTaxablePlace'] : '';
                $utilities = $info['utilities'] > 0 ? $info['utilities'] : '';
                $driver = $info['driver'] > 0 ? $info['driver'] : '';
                $upkeep = $info['upkeep'] > 0 ? $info['upkeep'] : '';
                $totalTaxableUtilities = $info['totalTaxableUtilities'] > 0 ? $info['totalTaxableUtilities'] : '';
                $hotel = $info['hotel'] > 0 ? $info['hotel'] : '';
                $hotelPaidEmployee = $info['hotelPaidEmployee'] > 0 ? $info['hotelPaidEmployee'] : '';
                $hotelTotal = $info['hotelTotal'] > 0 ? $info['hotelTotal'] : '';
                $incidentalBenefits = $info['incidentalBenefits'] > 0 ? $info['incidentalBenefits'] : '';
                $interestPayment = $info['interestPayment'] > 0 ? $info['interestPayment'] : '';
                $insurance = $info['insurance'] > 0 ? $info['insurance'] : '';
                $holidays = $info['holidays'] > 0 ? $info['holidays'] : '';
                $education = $info['education'] > 0 ? $info['education'] : '';
                $recreation = $info['recreation'] > 0 ? $info['recreation'] : '';
                $assetGain = $info['assetGain'] > 0 ? $info['assetGain'] : '';
                $vehicleGain = $info['vehicleGain'] > 0 ? $info['vehicleGain'] : '';
                $carBenefits = $info['carBenefits'] > 0 ? $info['carBenefits'] : '';
                $otherBenefits = $info['otherBenefits'] > 0 ? $info['otherBenefits'] : '';
                $totalBenefits = $info['totalBenefits'] > 0 ? $info['totalBenefits'] : '';

                $xml .= '<A8ARecord>
<ESubmissionSDSC xmlns="http://tempuri.org/ESubmissionSDSC.xsd">
<A8A2015ST>
<RecordType xmlns="http://www.iras.gov.sg/A8A2015">1</RecordType>
<IDType xmlns="http://www.iras.gov.sg/A8A2015">' . $info['idType'] . '</IDType>
<IDNo xmlns="http://www.iras.gov.sg/A8A2015">' . $info['empIDNo'] . '</IDNo>
<NameLine1 xmlns="http://www.iras.gov.sg/A8A2015">' . $info['empName'] . '</NameLine1>
<NameLine2 xmlns="http://www.iras.gov.sg/A8A2015"/>
<ResidenceAddressLine1 xmlns="http://www.iras.gov.sg/A8A2015">' . $info['address'] . '</ResidenceAddressLine1>
<ResidenceAddressLine2 xmlns="http://www.iras.gov.sg/A8A2015"/>
<ResidenceAddressLine3 xmlns="http://www.iras.gov.sg/A8A2015"/>
<OccupationFromDate xmlns="http://www.iras.gov.sg/A8A2015">' . str_replace('-','', $info['periodFrom'] ) . '</OccupationFromDate>
<OccupationToDate xmlns="http://www.iras.gov.sg/A8A2015">' . str_replace('-','', $info['periodTo'] ) . '</OccupationToDate>
<NoOfDays xmlns="http://www.iras.gov.sg/A8A2015">' . $info['days'] . '</NoOfDays>
<NoOfEmployeeSharePremises xmlns="http://www.iras.gov.sg/A8A2015">' . $info['numberShare'] . '</NoOfEmployeeSharePremises>
<AVOfPremises xmlns="http://www.iras.gov.sg/A8A2015">' . $annualValue . '</AVOfPremises>
<ValueFurnitureFittingInd xmlns="http://www.iras.gov.sg/A8A2015">F</ValueFurnitureFittingInd>
<ValueFurnitureFitting xmlns="http://www.iras.gov.sg/A8A2015">' . $furnitureValue . '</ValueFurnitureFitting>
<RentPaidToLandlord xmlns="http://www.iras.gov.sg/A8A2015">' . $rentPaidEmployer . '</RentPaidToLandlord>
<TaxableValuePlaceOfResidence xmlns="http://www.iras.gov.sg/A8A2015">' . $taxableValue . '</TaxableValuePlaceOfResidence>
<TotalRentPaidByEmployeePlaceOfResidence xmlns="http://www.iras.gov.sg/A8A2015">' . $rentPaidEmployee . '</TotalRentPaidByEmployeePlaceOfResidence>
<TotalTaxableValuePlaceOfResidence xmlns="http://www.iras.gov.sg/A8A2015">' . $totalTaxablePlace . '</TotalTaxableValuePlaceOfResidence>
<UtilitiesTelPagerSuitCaseAccessories xmlns="http://www.iras.gov.sg/A8A2015">' . $utilities . '</UtilitiesTelPagerSuitCaseAccessories>
<Driver xmlns="http://www.iras.gov.sg/A8A2015">' . $driver . '</Driver>
<ServantGardener xmlns="http://www.iras.gov.sg/A8A2015">' . $upkeep . '</ServantGardener>
<TaxableValueUtilitiesHouseKeeping xmlns="http://www.iras.gov.sg/A8A2015">' . $totalTaxableUtilities . '</TaxableValueUtilitiesHouseKeeping>
<ActualHotelAccommodation xmlns="http://www.iras.gov.sg/A8A2015">' . $hotel . '</ActualHotelAccommodation>
<AmountPaidByEmployee xmlns="http://www.iras.gov.sg/A8A2015">' . $hotelPaidEmployee . '</AmountPaidByEmployee>
<TaxableValueHotelAccommodation xmlns="http://www.iras.gov.sg/A8A2015">' . $hotelTotal . '</TaxableValueHotelAccommodation>
<CostOfLeavePassageAndIncidentalBenefits xmlns="http://www.iras.gov.sg/A8A2015">' . $incidentalBenefits . '</CostOfLeavePassageAndIncidentalBenefits>
<NoOfLeavePassageSelf xmlns="http://www.iras.gov.sg/A8A2015"/>
<NoOfLeavePassageSpouse xmlns="http://www.iras.gov.sg/A8A2015"/>
<NoOfLeavePassageChildren xmlns="http://www.iras.gov.sg/A8A2015"/>
<OHQStatus xmlns="http://www.iras.gov.sg/A8A2015"/>
<InterestPaidByEmployer xmlns="http://www.iras.gov.sg/A8A2015">' . $interestPayment . '</InterestPaidByEmployer>
<LifeInsurancePremiumsPaidByEmployer xmlns="http://www.iras.gov.sg/A8A2015">' . $insurance . '</LifeInsurancePremiumsPaidByEmployer>
<FreeOrSubsidisedHoliday xmlns="http://www.iras.gov.sg/A8A2015">' . $holidays . '</FreeOrSubsidisedHoliday>
<EducationalExpenses xmlns="http://www.iras.gov.sg/A8A2015">' . $education . '</EducationalExpenses>
<NonMonetaryAwardsForLongService xmlns="http://www.iras.gov.sg/A8A2015"/>
<EntranceOrTransferFeesToSocialClubs xmlns="http://www.iras.gov.sg/A8A2015">' . $recreation . '</EntranceOrTransferFeesToSocialClubs>
<GainsFromAssets xmlns="http://www.iras.gov.sg/A8A2015">' . $assetGain . '</GainsFromAssets>
<FullCostOfMotorVehicle xmlns="http://www.iras.gov.sg/A8A2015">' . $vehicleGain . '</FullCostOfMotorVehicle>
<CarBenefit xmlns="http://www.iras.gov.sg/A8A2015">' . $carBenefits . '</CarBenefit>
<OthersBenefits xmlns="http://www.iras.gov.sg/A8A2015">' . $otherBenefits . '</OthersBenefits>
<TotalBenefitsInKind xmlns="http://www.iras.gov.sg/A8A2015">' . $totalBenefits . '</TotalBenefitsInKind>
<Filler xmlns="http://www.iras.gov.sg/A8A2015"/>
<FieldReserved xmlns="http://www.iras.gov.sg/A8A2015"/>
</A8A2015ST>
</ESubmissionSDSC>
</A8ARecord>
';
            }

            $xml .= '</Details>
</A8A2015>';

            if( $readonly ) {
                return $xml;
            }
            header('Content-Type: text/xml');
            header('Content-Length: '.strlen( $xml ));
            header('Content-disposition: attachment; filename="A8A.xml');
            header('Cache-Control: public, must-revalidate, max-age=0');
            header('Pragma: public');
            header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
            echo $xml;
            exit;
        }
    }


    /**
     * Render main navigation
     * @return void
     */
    public function renderIra8a( $userID, $year ) {
        $EmployeeModel = new EmployeeModel( );
        $empInfo = $EmployeeModel->getIR8AInfo( $userID );

        if( $empInfo && is_numeric( $year ) ) {
            $startDate = Date::parseDateTime($year . '-01-01' );
            $endDate = Date::parseDateTime($year . '-12-31' );

            $UserItemModel = UserItemModel::getInstance( );
            $gross = $UserItemModel->getTotalGrossByUserIDRange( $userID, $startDate, $endDate );
            $additional = $UserItemModel->getTotalAdditionalByUserIDRange( $userID, $startDate, $endDate );
            $directorFee = $UserItemModel->getTotalDirectorFeeByUserIDRange( $userID, $startDate, $endDate );
            $transport = $UserItemModel->getTotalTransportByUserIDRange( $userID, $startDate, $endDate );
            $entertainment = $UserItemModel->getTotalEntertainmentByUserIDRange( $userID, $startDate, $endDate );
            $otherAllowance = $UserItemModel->getTotalOtherAllowanceByUserIDRange( $userID, $startDate, $endDate );
            $commission = $UserItemModel->getTotalCommissionByUserIDRange( $userID, $startDate, $endDate );
            $pension = $UserItemModel->getTotalPensionByUserIDRange( $userID, $startDate, $endDate );
            $gratuity = $UserItemModel->getTotalGratuityByUserIDRange( $userID, $startDate, $endDate );
            $notice = $UserItemModel->getTotalNoticeByUserIDRange( $userID, $startDate, $endDate );
            $exgratia = $UserItemModel->getTotalExGratiaByUserIDRange( $userID, $startDate, $endDate );
            $otherLumpsum = $UserItemModel->getTotalOtherLumpsumByUserIDRange( $userID, $startDate, $endDate );
            $stock = $UserItemModel->getTotalStockByUserIDRange( $userID, $startDate, $endDate );
            $benefits = $UserItemModel->getTotalBenefitsByUserIDRange( $userID, $startDate, $endDate );

            $UserTaxModel = UserTaxModel::getInstance( );
            $cpf = $UserTaxModel->getTotalCPFByUserIDRange( $userID, $startDate, $endDate );
            $donation = $UserTaxModel->getTotalDonationByUserIDRange( $userID, $startDate, $endDate );

            $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
            $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );
            $authUser = $EmployeeModel->getIR8AInfo( $userInfo['userID'] );

            $CompanyModel = new CompanyModel( );
            $companyInfo = $CompanyModel->loadInfo( );

            require_once( ROOT . 'Library/vendor/fpdm/src/fpdm.php' );
            $pdf = new \FPDM( UPLOAD_DIR . 'pdf/IR8A.pdf');

            $empStartYear = date('Y', strtotime( $empInfo['startDate'] ) );
            $empStartDate = $empStartYear == $year ? $empStartYear : 'NA';

            $startDate = \DateTime::createFromFormat('Y-m-d', $empInfo['startDate'] );
            $currentDate = new \DateTime( );
            $dateDiff = $currentDate->diff( $startDate );

            if( $dateDiff->y > 1 ) {
                $lengthYear = $dateDiff->y . ' years ';
            }
            else {
                $lengthYear = $dateDiff->y . ' year ';
            }

            if( $dateDiff->m > 1 ) {
                $lengthMonth = $dateDiff->m . ' months ';
            }
            else {
                $lengthMonth = $dateDiff->m . ' month ';
            }

            if( $dateDiff->d > 1 ) {
                $lengthDay = $dateDiff->d . ' days';
            }
            else {
                $lengthDay = $dateDiff->d . ' day';
            }

            $dirFeeDD = $dirFeeMM = $dirFeeYY = '';

            if( isset( $directorFee['remark'] ) && strstr( $directorFee['remark'], '/' ) ) {
                $approvedDate = explode('/', $directorFee['remark'] );

                if( isset( $approvedDate[2] ) ) {
                    $dirFeeDD = $approvedDate[0];
                    $dirFeeMM = $approvedDate[1];
                    $dirFeeYY = $approvedDate[2];
                }
            }

            $transportAmt = $entertainmentAmt = $otherAllowanceAmt = $totalComm = $pensionAmt =
            $gratuityAmt = $noticeAmt = $exgratiaAmt = $otherLumpsumAmt = 0;

            if( isset( $transport['amount'] ) ) $transportAmt = $transport['amount'];
            if( isset( $entertainment['amount'] ) ) $entertainmentAmt = $transport['amount'];
            if( isset( $otherAllowance['amount'] ) ) $otherAllowanceAmt = $otherAllowance['amount'];
            $totalAllowance = number_format( ($transportAmt+$entertainmentAmt+$otherAllowanceAmt), 2 );

            $grossCommFromDD = $grossCommFromMM = $grossCommFromYY =
            $grossCommToDD = $grossCommToMM = $grossCommToYY = '';

            $commSize = sizeof( $commission );
            if( $commSize > 0 ) {
                $i = 1;

                foreach( $commission as $row ) {
                    $totalComm += $row['amount'];

                    // Get the first date
                    if( $i == 1 ) {
                        $commFrom = explode('-', $row['startDate']);
                        $grossCommFromDD = $commFrom[2];
                        $grossCommFromMM = $commFrom[1];
                        $grossCommFromYY = $commFrom[0];
                    }

                    // Get the last date
                    if( $i == $commSize ) {
                        $commTo = explode('-', $row['startDate']);
                        $grossCommToDD = $commTo[2];
                        $grossCommToMM = $commTo[1];
                        $grossCommToYY = $commTo[0];
                    }
                    $i++;
                }
            }

            $pensionAmt = isset( $pension['amount'] ) ? $pension['amount'] : 0;
            $gratuityAmt = isset( $gratuity['amount'] ) ? $gratuity['amount'] : 0;
            $noticeAmt = isset( $notice['amount'] ) ? $notice['amount'] : 0;
            $exgratiaAmt = isset( $exgratia['amount'] ) ? $exgratia['amount'] : 0;
            $stockAmt = isset( $stock['amount'] ) ? $stock['amount'] : 0;
            $benefitsAmt = isset( $benefits['amount'] ) ? $benefits['amount'] : 0;
            $otherLumpsumAmt = isset( $otherLumpsum['amount'] ) ? $otherLumpsum['amount'] : 0;

            if( isset( $otherLumpsum['remark'] ) && $otherLumpsum['remark'] ) {
                $otherLumpsumAmt .= ' (' . $otherLumpsum['remark'] . ')';
            }

            $fields = array(
                //'formYear' => ($year+1) . '',
                'yearEndDate' => '31 Mar ' . $year,
                'giveByDate' => '1 Mar ' . ($year+1),
                'empRef'    => $companyInfo['regNumber'],
                'empIDNo' => $empInfo['nric'],
                'empName' => $empInfo['name'],
                'empDOB' => $empInfo['birthday'],
                'empGender' => $empInfo['gender'] == 'm' ? 'Male' : 'Female',
                'empNationality' => $empInfo['nationality'],
                'empAddress' => $empInfo['address'] . ' ' . $empInfo['postal'],
                'empDesignation' => $empInfo['designation'],
                'empBank' => $empInfo['bankName'],
                'empStartDate' => $empStartDate,
                'empEndDate' => $empInfo['endDate'] ? $empInfo['endDate'] : 'NA',
                'gross' => $gross['amount'],
                'bonusYear' => $year,
                'bonus' => isset( $additional['amount'] ) ? $additional['amount'] : 'NA',
                'dirFeeDD' => $dirFeeDD,
                'dirFeeMM' => $dirFeeMM,
                'dirFeeYY' => $dirFeeYY,
                'directorFee' => isset( $directorFee['amount'] ) ? $directorFee['amount'] : 'NA',
                'transport' => $transportAmt ? $transportAmt : 'NA',
                'entertainment' => $entertainmentAmt ? $entertainmentAmt : 'NA',
                'others' => $otherAllowanceAmt ? $otherAllowanceAmt : 'NA',
                'allowanceTotal' => $totalAllowance,
                'grossCommFromDD' => $grossCommFromDD,
                'grossCommFromMM' => $grossCommFromMM,
                'grossCommFromYY' => $grossCommFromYY,
                'grossCommToDD' => $grossCommToDD,
                'grossCommToMM' => $grossCommToMM,
                'grossCommToYY' => $grossCommToYY,
                'commMonthly' => $commSize == 12 ? '' : '---------',
                'commAdhoc' => $commSize < 12 ? '' : '-----------------------------------',
                'totalComm' => number_format( $totalComm,2 ),
                'pension' => $pensionAmt ? $pensionAmt : 'NA',
                'lumpSum' => '',
                'gratuity' => $gratuityAmt ? $gratuityAmt : 'NA',
                'noticePay' => $noticeAmt ? $noticeAmt : 'NA',
                'exGratia' => $exgratiaAmt ? $exgratiaAmt : 'NA',
                'otherIncome' => $otherLumpsumAmt ? $otherLumpsumAmt : 'NA',
                'compensation' => 'NA',
                'approveIRASYES' => '------',
                'approveIRASNO' => '------',
                'approveDate' => 'NA',
                'reasonPayment' => 'NA',
                'lengthService' =>  $lengthYear . $lengthMonth . $lengthDay,
                'retireFundName' => 'NA',
                'amtAccrued92' => 'NA',
                'amtAccrued93' => 'NA',
                'contriOutSGWithoutTax' => 'NA',
                'overseasFundName' => 'NA',
                'overseasFundAmt' => 'NA',
                'overseasContriMandYES' => '------',
                'overseasContriMandNO' => '------',
                'contriChargedYES' => '------',
                'contriChargedNO' => '------',
                'excessContriByEmployer' => 'NA',
                'gainsProfitESOP' => $stockAmt ? $stockAmt : 'NA',
                'benefitsInKind' => $benefitsAmt ? $benefitsAmt : 'NA',
                'total' => number_format( ($totalAllowance+$totalComm+$pensionAmt+$gratuityAmt+$noticeAmt+$exgratiaAmt+$otherLumpsumAmt+$stockAmt+$benefitsAmt),2 ),
                'remissionAmt' => '0.00',
                'overseasFullYear' => '------------',
                'overseasPartOfYear' => '------------',
                'exemptIncome' => '0.00',
                'empIncomeByEmpyerYES' => '------',
                'empIncomeByEmpyerNO' => '',
                'employerTaxBorne' => 'NA',
                'empTaxPaid' => 'NA',
                'deductFundName' => 'CPF',
                'cpf' => $cpf['amount'],
                'donation' => $donation['amount'],
                'contriMosque' => 'NA',
                'insurance' => 'NA',
                'employerName' => $companyInfo['name'],
                'employerAddress' => $companyInfo['address'],
                'authName' => $authUser['name'],
                'authDesignation' => $authUser['designation'],
                'authTel' => $authUser['mobile'],
                'authSig' => '',
                'authDate' => ''
            );

            $pdf->Load($fields,true);
            $pdf->Merge();
            $pdf->Flatten();
            $pdf->Output();
        }
    }
}
?>