<?php
namespace Markaxis\TaxFile;
use \Markaxis\Employee\EmployeeModel;
use \Markaxis\Payroll\UserItemModel, \Markaxis\Payroll\UserTaxModel;
use \Library\Util\Date, \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: IR8AModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class IR8AModel extends \Model {


    // Properties
    protected $IR8A;



    /**
     * IR8AModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/TaxFile/TaxFileRes');

        $this->IR8A = new IR8A( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserIDTFID( $userID, $tfID ) {
        return $this->IR8A->isFoundByUserIDTFID( $userID, $tfID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByTFID( $tfID ) {
        return $this->IR8A->getByTFID( $tfID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByUserIDTFID( $userID, $tfID ) {
        return $this->IR8A->getByUserIDTFID( $userID, $tfID );
    }


    /**
     * Set Pay Item Info
     * @return void
     */
    public function createDeclaration( $post ) {
        if( isset( $post['tfID'] ) && isset( $post['selected'] ) && is_array( $post['selected'] ) ) {
            $EmployeeModel = new EmployeeModel( );
            $empCount = 0;

            foreach( $post['selected'] as $userID ) {
                if( $empInfo = $EmployeeModel->getIR8AInfo( $userID ) ) {
                    $this->info = array(
                        'tfID' => $post['tfID'],
                        'userID' => $empInfo['userID'],
                        'empIDNo' => $empInfo['nric'],
                        'empName' => $empInfo['name'],
                        'empDOB' => $empInfo['birthday'],
                        'empGender' => $empInfo['gender'],
                        'empNationality' => $empInfo['nationalityID'],
                        'empAddress' => $empInfo['houseNo'] . ' ' . $empInfo['streetName'] . ' ' . $empInfo['levelUnit'] . ' ' . $empInfo['postal'],
                        'empDesignation' => $empInfo['designation'],
                        'empBank' => $empInfo['bkID'] ? $empInfo['bkID'] : NULL );

                    $this->info['completed'] = 1;

                    // If any of the fields above are blank..
                    foreach( $this->info as $field ) {
                        if( !$field ) {
                            $this->info['completed'] = 0;
                            break;
                        }
                    }

                    if( !$this->isFoundByUserIDTFID( $userID, $post['tfID'] ) ) {
                        $this->IR8A->insert('ir8a', $this->info );
                    }
                    else {
                        $this->IR8A->update('ir8a', $this->info,
                                            'WHERE userID = "' . (int)$userID . '" AND 
                                                          tfID = "' . (int)$post['tfID'] . '"' );
                    }
                    $empCount++;
                }
            }

            // Delete all and repopulate
            $this->IR8A->delete('ir8a','WHERE userID NOT IN (' . addslashes( implode(',', $post['selected'] ) ) . ')' );

            $TaxFileModel = TaxFileModel::getInstance( );
            $TaxFileModel->updateEmpCount( $post['tfID'], $empCount );
        }
    }


    /**
     * Save Pay Item information
     * @return mixed
     */
    public function prepareUserDeclaration( $data, $post ) {
        $startDate = Date::parseDateTime($post['year'] . '-01-01');
        $endDate = Date::parseDateTime($post['year'] . '-12-31');

        $UserItemModel = UserItemModel::getInstance( );
        $gross = $UserItemModel->getTotalGrossByUserIDRange( $data['empIR8AInfo']['userID'], $startDate, $endDate );
        $additional = $UserItemModel->getTotalAdditionalByUserIDRange( $data['empIR8AInfo']['userID'], $startDate, $endDate );
        $directorFee = $UserItemModel->getTotalDirectorFeeByUserIDRange( $data['empIR8AInfo']['userID'], $startDate, $endDate );
        $transport = $UserItemModel->getTotalTransportByUserIDRange( $data['empIR8AInfo']['userID'], $startDate, $endDate );
        $entertainment = $UserItemModel->getTotalEntertainmentByUserIDRange( $data['empIR8AInfo']['userID'], $startDate, $endDate );
        $otherAllowance = $UserItemModel->getTotalOtherAllowanceByUserIDRange( $data['empIR8AInfo']['userID'], $startDate, $endDate );
        $commission = $UserItemModel->getTotalCommissionByUserIDRange( $data['empIR8AInfo']['userID'], $startDate, $endDate );
        $pension = $UserItemModel->getTotalPensionByUserIDRange( $data['empIR8AInfo']['userID'], $startDate, $endDate );
        $gratuity = $UserItemModel->getTotalGratuityByUserIDRange( $data['empIR8AInfo']['userID'], $startDate, $endDate );
        $notice = $UserItemModel->getTotalNoticeByUserIDRange( $data['empIR8AInfo']['userID'], $startDate, $endDate );
        $exGratia = $UserItemModel->getTotalExGratiaByUserIDRange( $data['empIR8AInfo']['userID'], $startDate, $endDate );
        $otherLumpsum = $UserItemModel->getTotalOtherLumpsumByUserIDRange( $data['empIR8AInfo']['userID'], $startDate, $endDate );
        $stock = $UserItemModel->getTotalStockByUserIDRange( $data['empIR8AInfo']['userID'], $startDate, $endDate );
        $benefits = $UserItemModel->getTotalBenefitsByUserIDRange( $data['empIR8AInfo']['userID'], $startDate, $endDate );

        $UserTaxModel = UserTaxModel::getInstance( );
        $cpf = $UserTaxModel->getTotalCPFByUserIDRange( $data['empIR8AInfo']['userID'], $startDate, $endDate );
        $donation = $UserTaxModel->getTotalDonationByUserIDRange( $data['empIR8AInfo']['userID'], $startDate, $endDate );

        $empStartYear = date('Y', strtotime( $data['empIR8AInfo']['startDate'] ) );
        $empStartDate = $empStartYear == $post['year'] ? $data['empIR8AInfo']['startDate'] : NULL;

        $startDate = \DateTime::createFromFormat('Y-m-d', $data['empIR8AInfo']['startDate'] );
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

        $grossCommFromDate = $grossCommToDate = $directorFeeDate = NULL;

        if( isset( $directorFee['remark'] ) && strstr( $directorFee['remark'], '/' ) ) {
            $approvedDate = explode('/', $directorFee['remark'] );

            if( isset( $approvedDate[2] ) ) {
                $directorFeeDate = $approvedDate[2] . '-' . $approvedDate[1] . '-' . $approvedDate[0];
            }
        }

        $transportAmt = $entertainmentAmt = $otherAllowanceAmt = $totalComm = $pensionAmt =
        $gratuityAmt = $noticeAmt = $exGratiaAmt = $otherLumpsumAmt = $total = 0;

        if( isset( $transport['amount'] ) ) $transportAmt = $transport['amount'];
        if( isset( $entertainment['amount'] ) ) $entertainmentAmt = $transport['amount'];
        if( isset( $otherAllowance['amount'] ) ) $otherAllowanceAmt = $otherAllowance['amount'];
        $totalAllowance = $total = number_format( ($transportAmt+$entertainmentAmt+$otherAllowanceAmt), 2 );

        $commSize = sizeof( $commission );
        if( $commSize > 0 ) {
            $i = 1;

            foreach( $commission as $row ) {
                $totalComm += $row['amount'];
                $total += $row['amount'];

                // Get the first date
                if( $i == 1 ) {
                    $commFrom = explode('-', $row['startDate']);
                    $grossCommFromDate = $commFrom[0] . '-' . $commFrom[1] . '-' . $commFrom[2];
                }

                // Get the last date
                if( $i == $commSize ) {
                    $commTo = explode('-', $row['startDate']);
                    $grossCommToDate = $commTo[0] . '-' . $commTo[1] . '-' . $commTo[2];
                }
                $i++;
            }
        }

        $pensionAmt = $gratuityAmt = $noticeAmt = $exGratiaAmt = $stockAmt = $benefitsAmt = $otherLumpsumAmt = NULL;

        if( isset( $pension['amount'] ) ) {
            $pensionAmt = $pension['amount'];
            $total += $pensionAmt;
        }

        if( isset( $gratuity['amount'] ) ) {
            $gratuityAmt = $gratuity['amount'];
            $total += $gratuityAmt;
        }

        if( isset( $notice['amount'] ) ) {
            $noticeAmt = $notice['amount'];
            $total += $noticeAmt;
        }

        if( isset( $exGratia['amount'] ) ) {
            $exGratiaAmt = $exGratia['amount'];
            $total += $exGratiaAmt;
        }

        if( isset( $stock['amount'] ) ) {
            $stockAmt = $stock['amount'];
            $total += $stockAmt;
        }

        if( isset( $benefits['amount'] ) ) {
            $benefitsAmt = $benefits['amount'];
            $total += $benefitsAmt;
        }

        if( isset( $otherLumpsum['amount'] ) ) {
            $otherLumpsumAmt = $otherLumpsum['amount'];
            $total += $otherLumpsumAmt;
        }

        if( isset( $otherLumpsum['remark'] ) && $otherLumpsum['remark'] ) {
            $otherLumpsumAmt .= ' (' . $otherLumpsum['remark'] . ')';
        }

        $this->info = array(
            'empStartDate' => $empStartDate,
            'empEndDate' => $data['empIR8AInfo']['endDate'] ? $data['empIR8AInfo']['endDate'] : NULL,
            'gross' => $gross['amount'],
            'bonusYear' => $post['year'],
            'bonus' => isset( $additional['amount'] ) ? $additional['amount'] : NULL,
            'directorFeeDate' => $directorFeeDate,
            'directorFee' => isset( $directorFee['amount'] ) ? $directorFee['amount'] : NULL,
            'transport' => $transportAmt ? $transportAmt : NULL,
            'entertainment' => $entertainmentAmt ? $entertainmentAmt : NULL,
            'others' => $otherAllowanceAmt ? $otherAllowanceAmt : NULL,
            'allowanceTotal' => $totalAllowance,
            'grossCommFromDate' => $grossCommFromDate,
            'grossCommToDate' => $grossCommToDate,
            'commType' => $commSize == 12 ? 0 : 1,
            'totalComm' => $totalComm,
            'pension' => $pensionAmt ? $pensionAmt : NULL,
            'gratuity' => $gratuityAmt ? $gratuityAmt : NULL,
            'noticePay' => $noticeAmt ? $noticeAmt : NULL,
            'exGratia' => $exGratiaAmt ? $exGratiaAmt : NULL,
            'otherLumpSum' => $otherLumpsumAmt ? $otherLumpsumAmt : NULL,
            'lengthService' =>  $lengthYear . $lengthMonth . $lengthDay,
            'gainsProfitESOP' => $stockAmt ? $stockAmt : NULL,
            'benefitsInKind' => $benefitsAmt ? $benefitsAmt : NULL,
            'total' => $total,
            'deductFundName' => isset( $cpf['amount'] ) ? 'CPF' : NULL,
            'cpf' => isset( $cpf['amount'] ) ? $cpf['amount'] : NULL,
            'donation' => isset( $donation['amount'] ) ? $donation['amount'] : NULL
        );

        if( $ir8aInfo = $this->getByUserIDTFID( $data['empIR8AInfo']['userID'], $post['tfID'] ) ) {
            $this->IR8A->update('ir8a', $this->info,
                                'WHERE tfID = "' . (int)$post['tfID']  . '" AND
                                              userID = "' . (int)$data['empIR8AInfo']['userID'] . '"' );

            $this->info['tfID'] = $post['tfID'];
            $this->info['userID'] = $data['empIR8AInfo']['userID'];
            $this->info['completed'] = $ir8aInfo['completed'];
            return $this->info;
        }
    }


    /**
     * Set Pay Item Info
     * @return bool
     */
    public function saveIr8a( $post ) {
        if( isset( $post['data']['tfID'] ) && isset( $post['data']['userID'] ) ) {
            if( $this->isFoundByUserIDTFID( $post['data']['userID'], $post['data']['tfID'] ) ) {
                $this->info = array( );
                $this->info['otherLumpSumRemark'] = Validator::stripTrim( $post['data']['otherLumpSumRemark'] );
                $this->info['compensation'] = (float)$post['data']['compensation'];
                $this->info['reasonPayment'] = Validator::stripTrim( $post['data']['reasonPayment'] );
                $this->info['basisPayment'] = Validator::stripTrim( $post['data']['basisPayment'] );
                $this->info['retireFundName'] = Validator::stripTrim( $post['data']['retireFundName'] );
                $this->info['amtAccrued92'] = (float)$post['data']['amtAccrued92'];
                $this->info['amtAccrued93'] = (float)$post['data']['amtAccrued93'];
                $this->info['contriOutSGWithoutTax'] = (float)$post['data']['contriOutSGWithoutTax'];
                $this->info['overseasFundName'] = Validator::stripTrim( $post['data']['overseasFundName'] );
                $this->info['overseasFundAmt'] = (float)$post['data']['overseasFundAmt'];
                $this->info['excessContriByEmployer'] = (float)$post['data']['excessContriByEmployer'];
                $this->info['remissionAmt'] = (float)$post['data']['remissionAmt'];
                $this->info['exemptIncome'] = (float)$post['data']['exemptIncome'];
                $this->info['employerTaxBorne'] = (float)$post['data']['employerTaxBorne'];
                $this->info['empTaxPaid'] = (float)$post['data']['empTaxPaid'];
                $this->info['contriMosque'] = (float)$post['data']['contriMosque'];
                $this->info['insurance'] = (float)$post['data']['insurance'];

                if( checkdate( (int)$post['data']['approvedMonth'], (int)$post['data']['approvedDay'], (int)$post['data']['approvedYear'] ) ) {
                    $this->info['approveDate'] = $post['data']['approvedYear'] . '-' .
                                                 $post['data']['approvedMonth'] . '-' .
                                                 $post['data']['approvedDay'];
                }

                if( isset( $post['data']['approveIRAS'] ) ) {
                    $this->info['approveIRAS'] = $post['data']['approveIRAS'] ? 1 : 0;
                }

                if( isset( $post['data']['overseasContriMand'] ) ) {
                    $this->info['overseasContriMand'] = $post['data']['overseasContriMand'] ? 1 : 0;
                }

                if( isset( $post['data']['contributionCharged'] ) ) {
                    $this->info['contributionCharged'] = $post['data']['contributionCharged'] ? 1 : 0;
                }

                if( isset( $post['data']['overseasPosting'] ) ) {
                    $this->info['overseasPosting'] = $post['data']['overseasPosting'] ? 1 : 0;
                }

                if( isset( $post['data']['taxBorne'] ) ) {
                    $this->info['taxBorne'] = $post['data']['taxBorne'] ? 1 : 0;
                }

                $this->IR8A->update('ir8a', $this->info,
                    'WHERE tfID = "' . (int)$post['data']['tfID']  . '" AND
                                              userID = "' . (int)$post['data']['userID'] . '"' );

                return true;
            }
        }
        return false;
    }
}
?>