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
 * @version $Id: IR8AView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class IR8AView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $PayrollRes;
    protected $TaxFileRes;
    protected $View;
    protected $IR8AModel;


    /**
    * IR8AView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->TaxFileRes = $this->i18n->loadLanguage('Markaxis/TaxFile/TaxFileRes');
        $this->PayrollRes = $this->i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->IR8AModel = IR8AModel::getInstance( );

        $this->View->setJScript( array( 'plugins/moment' => 'moment.min.js',
                                        'plugins/tables/datatables' => array( 'datatables.min.js', 'checkboxes.min.js'),
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
    public function renderXML( $tfID, $readonly=false ) {
        $TaxFileModel = TaxFileModel::getInstance( );
        $tfInfo = $TaxFileModel->getByTFID( $tfID );
        $ir8aInfo = $this->IR8AModel->getByTFID( $tfID );

        if( $tfInfo && $ir8aInfo ) {
            $xml = '<?xml version="1.0" encoding="utf-8" standalone="no"?>
<IR8A xmlns="http://www.iras.gov.sg/IR8ADef">
<IR8AHeader>
<ESubmissionSDSC xmlns="http://tempuri.org/ESubmissionSDSC.xsd">
<FileHeaderST>
<RecordType>0</RecordType>
<Source>' . $tfInfo['sourceType'] . '</Source>
<BasisYear>' . $tfInfo['fileYear'] . '</BasisYear>
<PaymentType>08</PaymentType>
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
</IR8AHeader>
<Details>';

            $totalPayment = $totalSalary = $totalBonus = $totalDirectorsFees =
            $totalOthers = $totalExemptIncome = $TaxBorneByEmployer = $TaxBorneByEmployee =
            $totalDonation = $totalCPF = $totalInsurance = $totalMBF = 0;

            foreach( $ir8aInfo as $info ) {
                if( $info['state'] || $info['city'] ) {
                    $addressType = 'F';
                    $houseNo = $streetName = $levelNo = $unitNo = '';
                    $address = $info['houseNo'] . ' ' . $info['streetName'] .
                               $info['levelUnit'];

                    // This is for foreign so make sure not in Singapore
                    if( $info['countryID'] != 1 && isset( IRASCountryCodeHelper::getL10nList( )[$info['countryID']] ) ) {
                        $CountryCode = IRASCountryCodeHelper::getL10nList( )[$info['countryID']];
                    }
                }
                else {
                    $addressType = 'L';
                    $address = $CountryCode = $levelNo = $unitNo = '';
                    $houseNo = $info['houseNo'];
                    $streetName = $info['streetName'];

                    if( $info['levelUnit'] ) {
                        // in case there is #
                        $levelUnit = str_replace('#', '', $info['levelUnit'] );
                        $levelUnit = explode('-', $levelUnit );

                        if( isset( $levelUnit[0] ) && isset( $levelUnit[1] ) ) {
                            $levelNo = $levelUnit[0];
                            $unitNo = $levelUnit[1];
                        }
                    }
                }

                $benefitsInKind = '';
                if( $info['benefitsInKind'] ) {
                    $benefitsInKind = 'Y';
                }

                $IncomeTaxBorneByEmployer = '';
                if( $info['taxBorne'] ) {
                    if( $info['employerTaxBorne'] ) {
                        // Partially borne by employer
                        $IncomeTaxBorneByEmployer = 'P';
                    }
                    else if( $info['empTaxPaid'] ) {
                        // A fixed amount of income tax is borne by employee.
                        $IncomeTaxBorneByEmployer = 'H';
                    }
                    else {
                        // Fully borne by employer
                        $IncomeTaxBorneByEmployer = 'F';
                    }
                }

                $GratuityNoticePymExGratiaPaid = $GratuityNoticePymExGratia = '';
                if( $info['gratuity'] || $info['noticePay'] || $info['exGratia'] || $info['otherLumpSum'] ) {
                    $GratuityNoticePymExGratiaPaid = 'Y';
                    $GratuityNoticePymExGratia = ($info['gratuity']+$info['noticePay']+$info['exGratia']+$info['otherLumpSum'] );
                }

                $CompensationRetrenchmentBenefitsPaid = $ApprovalObtainedFromIRAS = '';
                if( $info['compensation'] || $info['approveIRAS'] ) {
                    $CompensationRetrenchmentBenefitsPaid = 'Y';

                    if( $info['approveIRAS'] ) {
                        $ApprovalObtainedFromIRAS = 'Y';

                    }
                    else {
                        $ApprovalObtainedFromIRAS = 'N';
                    }
                }

                $CessationProvisions = '';
                if( $info['empStartDate'] ) {
                    // Cannot be blank if Date of commencement is before 01/01/1969
                    if( strtotime( $info['empStartDate'] ) < mktime(0,0,0, 1, 1, 1969 ) ) {
                        $CessationProvisions = 'Y';
                    }
                }

                if( $info['empEndDate'] ) {
                    // Date of cessation is not blank and is within the Income Year in the Header Record
                    $endYear = date('Y', strtotime( $info['empEndDate'] ) );

                    if( $endYear == $tfInfo['fileYear'] ) {
                        $CessationProvisions = 'Y';
                    }
                }

                $PaymentPeriodFromDate = $tfInfo['fileYear'] . '0101';
                $PaymentPeriodToDate = $tfInfo['fileYear'] . '1231';

                $GrossCommissionAmount = $GrossCommissionIndicator = '';
                if( $info['totalComm'] > 0 ) {
                    $GrossCommissionAmount = $info['totalComm'];

                    if( $info['commType'] == 0 ) {
                        $GrossCommissionIndicator = 'M';
                    }
                    else if( $info['commType'] == 1 ) {
                        $GrossCommissionIndicator = 'O';
                    }
                }

                $BonusDecalrationDate = '';
                if( $info['bonus'] ) {
                    $BonusDecalrationDate = $tfInfo['fileYear'] . '1231';
                }

                $IR8SApplicable = '';
                if( $info['contriOutSGWithoutTax'] ) {
                    $IR8SApplicable = 'Y';
                }

                $Others = ($info['pension']+$info['transport']+$info['entertainment']+$info['others']+
                           $info['amtAccrued93']+$info['contriOutSGWithoutTax']+
                           $info['excessContriByEmployer']+$info['gainsProfitESOP']+$info['benefitsInKind']);

                if( $GrossCommissionAmount ) {
                    $Others += $GrossCommissionAmount;
                }

                if( $GratuityNoticePymExGratia ) {
                    $Others += $GratuityNoticePymExGratia;
                }

                $Amount = ($info['gross']+$info['bonus']+$info['directorFee']+$Others);

                $xml .= '
<IR8ARecord>
<ESubmissionSDSC xmlns="http://tempuri.org/ESubmissionSDSC.xsd">
<IR8AST>
<RecordType xmlns="http://www.iras.gov.sg/IR8A">1</RecordType>
<IDType xmlns="http://www.iras.gov.sg/IR8A">' . $info['idType'] . '</IDType>
<IDNo xmlns="http://www.iras.gov.sg/IR8A">' . $info['empIDNo'] . '</IDNo>
<NameLine1 xmlns="http://www.iras.gov.sg/IR8A">' . $info['empName'] . '</NameLine1>
<NameLine2 xmlns="http://www.iras.gov.sg/IR8A"/>
<AddressType xmlns="http://www.iras.gov.sg/IR8A">' . $addressType . '</AddressType>
<BlockNo xmlns="http://www.iras.gov.sg/IR8A">' . $houseNo . '</BlockNo>
<StName xmlns="http://www.iras.gov.sg/IR8A">' . $streetName . '</StName>
<LevelNo xmlns="http://www.iras.gov.sg/IR8A">' . $levelNo . '</LevelNo>
<UnitNo xmlns="http://www.iras.gov.sg/IR8A">' . $unitNo . '</UnitNo>
<PostalCode xmlns="http://www.iras.gov.sg/IR8A">' . $info['postal'] . '</PostalCode>
<AddressLine1 xmlns="http://www.iras.gov.sg/IR8A">' . $address . '</AddressLine1>
<AddressLine2 xmlns="http://www.iras.gov.sg/IR8A"/>
<AddressLine3 xmlns="http://www.iras.gov.sg/IR8A"/>
<TX_UF_POSTAL_CODE xmlns="http://www.iras.gov.sg/IR8A"/>
<CountryCode xmlns="http://www.iras.gov.sg/IR8A">' . $CountryCode . '</CountryCode>
<Nationality xmlns="http://www.iras.gov.sg/IR8A">' . $info['empNationality'] . '</Nationality>
<Sex xmlns="http://www.iras.gov.sg/IR8A">' . strtoupper( $info['gender'] ) . '</Sex>
<DateOfBirth xmlns="http://www.iras.gov.sg/IR8A">' . str_replace('-','', $info['birthday'] ) . '</DateOfBirth>
<Amount xmlns="http://www.iras.gov.sg/IR8A">' . $Amount . '</Amount>
<PaymentPeriodFromDate xmlns="http://www.iras.gov.sg/IR8A">' . $PaymentPeriodFromDate . '</PaymentPeriodFromDate>
<PaymentPeriodToDate xmlns="http://www.iras.gov.sg/IR8A">' . $PaymentPeriodToDate . '</PaymentPeriodToDate>
<MBF xmlns="http://www.iras.gov.sg/IR8A">' . $info['contriMosque'] . '</MBF>
<Donation xmlns="http://www.iras.gov.sg/IR8A">' . $info['donation'] . '</Donation>
<CPF xmlns="http://www.iras.gov.sg/IR8A">' . $info['cpf'] . '</CPF>
<Insurance xmlns="http://www.iras.gov.sg/IR8A">' . $info['insurance'] . '</Insurance>
<Salary xmlns="http://www.iras.gov.sg/IR8A">' . $info['gross'] . '</Salary>
<Bonus xmlns="http://www.iras.gov.sg/IR8A">' . $info['bonus']  . '</Bonus>
<DirectorsFees xmlns="http://www.iras.gov.sg/IR8A">' . $info['directorFee'] . '</DirectorsFees>
<Others xmlns="http://www.iras.gov.sg/IR8A">' . $Others . '</Others>
<ShareOptionGainsS101g xmlns="http://www.iras.gov.sg/IR8A">' . $info['gainsProfitESOP'] . '</ShareOptionGainsS101g>
<ExemptIncome xmlns="http://www.iras.gov.sg/IR8A">' . $info['exemptIncome'] . '</ExemptIncome>
<IncomeForTaxBorneByEmployer xmlns="http://www.iras.gov.sg/IR8A">' . $info['employerTaxBorne'] . '</IncomeForTaxBorneByEmployer>
<IncomeForTaxBorneByEmployee xmlns="http://www.iras.gov.sg/IR8A">' . $info['empTaxPaid'] . '</IncomeForTaxBorneByEmployee>
<BenefitsInKind xmlns="http://www.iras.gov.sg/IR8A">' . $benefitsInKind . '</BenefitsInKind>
<S45Applicable xmlns="http://www.iras.gov.sg/IR8A"/>
<IncomeTaxBorneByEmployer xmlns="http://www.iras.gov.sg/IR8A">' . $IncomeTaxBorneByEmployer . '</IncomeTaxBorneByEmployer>
<GratuityNoticePymExGratiaPaid xmlns="http://www.iras.gov.sg/IR8A">' . $GratuityNoticePymExGratiaPaid . '</GratuityNoticePymExGratiaPaid>
<CompensationRetrenchmentBenefitsPaid xmlns="http://www.iras.gov.sg/IR8A">' . $CompensationRetrenchmentBenefitsPaid . '</CompensationRetrenchmentBenefitsPaid>
<ApprovalObtainedFromIRAS xmlns="http://www.iras.gov.sg/IR8A">' . $ApprovalObtainedFromIRAS . '</ApprovalObtainedFromIRAS>
<ApprovalDate xmlns="http://www.iras.gov.sg/IR8A">' . str_replace('-','', $info['approveDate'] ) . '</ApprovalDate>
<CessationProvisions xmlns="http://www.iras.gov.sg/IR8A">' . $CessationProvisions . '</CessationProvisions>
<IR8SApplicable xmlns="http://www.iras.gov.sg/IR8A">' . $IR8SApplicable . '</IR8SApplicable>
<ExemptOrRemissionIncomeIndicator xmlns="http://www.iras.gov.sg/IR8A"/>
<CompensationAndGratuity xmlns="http://www.iras.gov.sg/IR8A"/>
<GrossCommissionAmount xmlns="http://www.iras.gov.sg/IR8A">' . $GrossCommissionAmount . '</GrossCommissionAmount>
<GrossCommissionPeriodFrom xmlns="http://www.iras.gov.sg/IR8A">' . str_replace('-','', $info['grossCommFromDate'] ) . '</GrossCommissionPeriodFrom>
<GrossCommissionPeriodTo xmlns="http://www.iras.gov.sg/IR8A">' . str_replace('-','', $info['grossCommToDate'] ) . '</GrossCommissionPeriodTo>
<GrossCommissionIndicator xmlns="http://www.iras.gov.sg/IR8A">' . $GrossCommissionIndicator . '</GrossCommissionIndicator>
<Pension xmlns="http://www.iras.gov.sg/IR8A">' . $info['pension'] . '</Pension>
<TransportAllowance xmlns="http://www.iras.gov.sg/IR8A">' . $info['transport'] . '</TransportAllowance>
<EntertainmentAllowance xmlns="http://www.iras.gov.sg/IR8A">' . $info['entertainment'] . '</EntertainmentAllowance>
<OtherAllowance xmlns="http://www.iras.gov.sg/IR8A">' . $info['others'] . '</OtherAllowance>
<GratuityNoticePymExGratia xmlns="http://www.iras.gov.sg/IR8A">' . $GratuityNoticePymExGratia . '</GratuityNoticePymExGratia>
<RetrenchmentBenefits xmlns="http://www.iras.gov.sg/IR8A">' . ($info['amtAccrued92']+$info['amtAccrued93']) . '</RetrenchmentBenefits>
<RetrenchmentBenefitsUpto311292 xmlns="http://www.iras.gov.sg/IR8A">' . $info['amtAccrued92'] . '</RetrenchmentBenefitsUpto311292>
<RetrenchmentBenefitsFrom1993 xmlns="http://www.iras.gov.sg/IR8A">' . $info['amtAccrued93'] . '</RetrenchmentBenefitsFrom1993>
<EmployerContributionToPensionOrPFOutsideSg xmlns="http://www.iras.gov.sg/IR8A">' . $info['contriOutSGWithoutTax'] . '</EmployerContributionToPensionOrPFOutsideSg>
<ExcessEmployerContributionToCPF xmlns="http://www.iras.gov.sg/IR8A">' . $info['excessContriByEmployer'] . '</ExcessEmployerContributionToCPF>
<ShareOptionGainsS101b xmlns="http://www.iras.gov.sg/IR8A">' . $info['gainsProfitESOP'] . '</ShareOptionGainsS101b>
<BenefitsInKindValue xmlns="http://www.iras.gov.sg/IR8A">' . $info['benefitsInKind'] . '</BenefitsInKindValue>
<EmployeesVoluntaryContributionToCPF xmlns="http://www.iras.gov.sg/IR8A"/>
<Designation xmlns="http://www.iras.gov.sg/IR8A">' . $info['empDesignation'] . '</Designation>
<CommencementDate xmlns="http://www.iras.gov.sg/IR8A">' . str_replace('-','', $info['empStartDate'] ) . '</CommencementDate>
<CessationDate xmlns="http://www.iras.gov.sg/IR8A">' . str_replace('-','', $info['empEndDate'] ) . '</CessationDate>
<BonusDecalrationDate xmlns="http://www.iras.gov.sg/IR8A">' . $BonusDecalrationDate . '</BonusDecalrationDate>
<DirectorsFeesApprovalDate xmlns="http://www.iras.gov.sg/IR8A">' . str_replace('-','', $info['directorFeeDate'] ) . '</DirectorsFeesApprovalDate>
<RetirementBenefitsFundName xmlns="http://www.iras.gov.sg/IR8A">' . $info['entertainment'] . '</RetirementBenefitsFundName>
<DesignatedPensionOrProvidentFundName xmlns="http://www.iras.gov.sg/IR8A">' . $info['deductFundName'] . '</DesignatedPensionOrProvidentFundName>
<BankName xmlns="http://www.iras.gov.sg/IR8A">' . $info['empBank'] . '</BankName>
<PayrollDate xmlns="http://www.iras.gov.sg/IR8A">' . $tfInfo['fileYear'] . '1212</PayrollDate>
<Filler xmlns="http://www.iras.gov.sg/IR8A">MARKAXIS</Filler>
<GratuityOrCompensationDetailedInfo xmlns="http://www.iras.gov.sg/IR8A"/>
<ShareOptionGainsDetailedInfo xmlns="http://www.iras.gov.sg/IR8A"/>
<Remarks xmlns="http://www.iras.gov.sg/IR8A"/>
</IR8AST>
</ESubmissionSDSC>
</IR8ARecord>
';
                $totalPayment += $Amount;
                $totalSalary += $info['gross'];
                $totalBonus += $info['bonus'];
                $totalDirectorsFees += $info['directorFee'];
                $totalOthers += $Others;
                $totalExemptIncome += $info['exemptIncome'];
                $TaxBorneByEmployer += $info['employerTaxBorne'];
                $TaxBorneByEmployee += $info['empTaxPaid'];
                $totalDonation += $info['donation'];
                $totalCPF += $info['cpf'];
                $totalInsurance += $info['insurance'];
                $totalMBF += $info['contriMosque'];
            }

            $xml .= '</Details>
<IR8ATrailer>
<ESubmissionSDSC xmlns="http://tempuri.org/ESubmissionSDSC.xsd">
<IR8ATrailerST>
<RecordType>2</RecordType>
<NoOfRecords>' . sizeof( $ir8aInfo ) . '</NoOfRecords>
<TotalPayment>' . $totalPayment . '</TotalPayment>
<TotalSalary>' . $totalSalary . '</TotalSalary>
<TotalBonus>' . $totalBonus . '</TotalBonus>
<TotalDirectorsFees>' . $totalDirectorsFees . '</TotalDirectorsFees>
<TotalOthers>' . $totalOthers . '</TotalOthers>
<TotalExemptIncome>' . $totalExemptIncome . '</TotalExemptIncome>
<TotalIncomeForTaxBorneByEmployer>' . $TaxBorneByEmployer . '</TotalIncomeForTaxBorneByEmployer>
<TotalIncomeForTaxBorneByEmployee>' . $TaxBorneByEmployee . '</TotalIncomeForTaxBorneByEmployee>
<TotalDonation>' . $totalDonation . '</TotalDonation>
<TotalCPF>' . $totalCPF . '</TotalCPF>
<TotalInsurance>' . $totalInsurance . '</TotalInsurance>
<TotalMBF>' . $totalMBF . '</TotalMBF>
<Filler/>
</IR8ATrailerST>
</ESubmissionSDSC>
</IR8ATrailer>
</IR8A>';

            if( $readonly ) {
                return $xml;
            }

            header('Content-Type: text/xml');
            header('Content-Length: '.strlen( $xml ));
            header('Content-disposition: attachment; filename="IR8A.xml');
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
    public function renderIr8a( $userID, $year ) {
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