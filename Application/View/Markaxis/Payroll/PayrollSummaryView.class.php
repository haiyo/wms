<?php
namespace Markaxis\Payroll;
use \Markaxis\Company\CompanyModel;
use \Markaxis\Expense\ExpenseModel, \Markaxis\Expense\ClaimModel;
use \Aurora\User\UserImageModel;
use \Aurora\Admin\AdminView;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PayrollSummaryView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollSummaryView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $PayrollSummaryModel;


    /**
    * PayrollSummaryView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->PayrollSummaryModel = PayrollSummaryModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSlip( $puID, $userID, $processDate, $data ) {
        $PayrollModel = PayrollModel::getInstance( );
        $userInfo = $PayrollModel->getCalculateUserInfo( $userID );

        $CompanyModel = new CompanyModel( );

        $UserImageModel = UserImageModel::getInstance( );

        $vars = array( 'TPLVAR_LOGO' => $CompanyModel->getLogo('slip_uID'),
                       'TPLVAR_IMAGE' => $UserImageModel->getImgLinkByUserID( $userID ),
                       'TPLVAR_USERID' => $userID,
                       'TPLVAR_FNAME' => $userInfo['fname'],
                       'TPLVAR_LNAME' => $userInfo['lname'],
                       'TPLVAR_PROCESS_DATE' => $processDate,
                       'TPLVAR_DEPARTMENT' => $data['empInfo']['department'],
                       'TPLVAR_DESIGNATION' => $data['empInfo']['designation'],
                       'TPLVAR_START_DATE' => $data['empInfo']['startDate'],
                       'TPLVAR_CONTRACT_TYPE' => $data['empInfo']['contractType'],
                       'TPLVAR_PAY_PERIOD' => $processDate );

        $PayrollUserItemModel = PayrollUserItemModel::getInstance( );
        $itemInfo = $PayrollUserItemModel->getByPuID( $puID );

        $vars['dynamic']['item'] = false;
        $totalClaim = 0;

        if( sizeof( $itemInfo ) > 0 ) {
            $ItemModel = ItemModel::getInstance( );
            $itemList = $ItemModel->getList( );

            foreach( $itemInfo as $item ) {
                $vars['dynamic']['item'][] = array( 'TPLVAR_PAYROLL_ITEM' => $itemList[$item['piID']],
                    'TPLVAR_AMOUNT' => $data['empInfo']['currency'] .
                                        number_format( $item['amount'],2 ),
                    'TPLVAR_REMARK' => $item['remark'] );
            }

            $ClaimModel = ClaimModel::getInstance( );
            $claimList = $ClaimModel->getProcessedByUserID( $data['empInfo']['userID'] );

            if( isset( $claimList ) ) {
                $ExpenseModel = ExpenseModel::getInstance( );
                $expenseList = $ExpenseModel->getList( );

                foreach( $claimList as $claim ) {
                    $totalClaim += $claim['amount'];

                    $vars['dynamic']['item'][] = array( 'TPLVAR_PAYROLL_ITEM' => $expenseList[$claim['eiID']],
                        'TPLVAR_AMOUNT' => $data['empInfo']['currency'] .
                                            number_format( $claim['amount'],2 ),
                        'TPLVAR_REMARK' => $claim['descript'] );
                }
            }
        }
        $summary = $this->PayrollSummaryModel->getByPuID( $puID );

        $vars['dynamic']['deductionSummary'] = false;

        $vars['dynamic']['deductionSummary'][] = array( 'TPLVAR_TITLE' => $this->L10n->getContents('LANG_TOTAL_CLAIM'),
            'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
            'TPLVAR_AMOUNT' => number_format( $totalClaim,2 ) );

        $PayrollUserTaxModel = PayrollUserTaxModel::getInstance( );
        $userTaxInfo = $PayrollUserTaxModel->getByPuID( $puID );

        if( sizeof( $userTaxInfo ) ) {
            foreach( $userTaxInfo as $userTax ) {
                $vars['dynamic']['deductionSummary'][] = array( 'TPLVAR_TITLE' => $userTax['remark'],
                    'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
                    'TPLVAR_AMOUNT' => number_format( $userTax['amount'],2 ) );
            }
        }

        $vars['TPLVAR_CURRENCY'] = $data['empInfo']['currency'];
        $vars['TPLVAR_GROSS_AMOUNT'] = number_format( $summary['gross'],2 );
        $vars['TPLVAR_CLAIM_AMOUNT'] = number_format( $summary['claim'],2 );
        $vars['TPLVAR_NET_AMOUNT'] = number_format( $summary['net'],2 );

        $html = $this->View->renderHeader( );
        $html .= $this->View->render( 'markaxis/payroll/slip.tpl', $vars );

        require_once LIB . 'vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf();
        //$mpdf->SetProtection( array( 'print-highres' ), '123', '1234' );
        $mpdf->WriteHTML( $html );
        $mpdf->Output('payslip-' . $processDate . '.pdf','I' );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderProcessForm( $puID, $userID, $processDate, $data ) {
        $PayrollModel = PayrollModel::getInstance( );
        $userInfo = $PayrollModel->getCalculateUserInfo( $userID );

        $UserImageModel = UserImageModel::getInstance( );

        $vars = array( 'TPLVAR_IMAGE' => $UserImageModel->getImgLinkByUserID( $userID ),
                       'TPLVAR_USERID' => $userID,
                       'TPLVAR_FNAME' => $userInfo['fname'],
                       'TPLVAR_LNAME' => $userInfo['lname'],
                       'TPLVAR_PROCESS_DATE' => $processDate );

        $PayrollUserItemModel = PayrollUserItemModel::getInstance( );
        $itemInfo = $PayrollUserItemModel->getByPuID( $puID );

        $vars['dynamic']['item'] = false;
        $totalClaim = 0;

        if( sizeof( $itemInfo ) > 0 ) {
            $ItemModel = ItemModel::getInstance( );
            $itemList = $ItemModel->getList( );

            foreach( $itemInfo as $item ) {
                $vars['dynamic']['item'][] = array( 'TPLVAR_PAYROLL_ITEM' => $itemList[$item['piID']],
                                                    'TPLVAR_AMOUNT' => $data['empInfo']['currency'] .
                                                                       number_format( $item['amount'],2 ),
                                                    'TPLVAR_REMARK' => $item['remark'] );
            }

            $ClaimModel = ClaimModel::getInstance( );
            $claimList = $ClaimModel->getProcessedByUserID( $data['empInfo']['userID'] );

            if( isset( $claimList ) ) {
                $ExpenseModel = ExpenseModel::getInstance( );
                $expenseList = $ExpenseModel->getList( );

                foreach( $claimList as $claim ) {
                    $totalClaim += $claim['amount'];

                    $vars['dynamic']['item'][] = array( 'TPLVAR_PAYROLL_ITEM' => $expenseList[$claim['eiID']],
                                                        'TPLVAR_AMOUNT' => $data['empInfo']['currency'] .
                                                                            number_format( $claim['amount'],2 ),
                                                        'TPLVAR_REMARK' => $claim['descript'] );
                }
            }
        }
        $vars['TPL_PROCESS_SUMMARY'] = $this->renderProcessSummary( $puID, $data, $totalClaim );

        if( isset( $data['col_1'] ) ) $vars['TPL_COL_1'] = $data['col_1'];
        if( isset( $data['col_2'] ) ) $vars['TPL_COL_2'] = $data['col_2'];
        if( isset( $data['col_3'] ) ) $vars['TPL_COL_3'] = $data['col_3'];
        return $this->View->render( 'markaxis/payroll/savedProcess.tpl', $vars );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderProcessSummary( $puID, $data, $totalClaim ) {
        $summary = $this->PayrollSummaryModel->getByPuID( $puID );

        $PayrollLevyModel = PayrollLevyModel::getInstance( );
        $levyInfo = $PayrollLevyModel->getByPuID( $puID );

        $vars['dynamic']['employerItem'] = $vars['dynamic']['deductionSummary'] = false;
        $totalLevy = $totalContribution = 0;

        if( sizeof( $levyInfo ) ) {
            foreach( $levyInfo as $levy ) {
                $totalLevy += $levy['amount'];

                $vars['dynamic']['employerItem'][] = array( 'TPLVAR_TITLE' => $levy['title'],
                                                            'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
                                                            'TPLVAR_AMOUNT' => number_format( $levy['amount'],2 ) );
            }
        }

        if( $totalLevy ) {
            $vars['dynamic']['employerItem'][] = array( 'TPLVAR_TITLE' => $this->L10n->getContents('LANG_TOTAL_EMPLOYER_LEVY'),
                                                        'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
                                                        'TPLVAR_AMOUNT' => number_format( $totalLevy,2 ) );
        }

        $PayrollContributionModel = PayrollContributionModel::getInstance( );
        $contriInfo = $PayrollContributionModel->getByPuID( $puID );

        if( sizeof( $contriInfo ) ) {
            foreach( $contriInfo as $contribution ) {
                $totalContribution += $contribution['amount'];

                $vars['dynamic']['employerItem'][] = array( 'TPLVAR_TITLE' => $contribution['title'],
                                                            'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
                                                            'TPLVAR_AMOUNT' => number_format( $contribution['amount'],2 ) );
            }
        }

        if( $totalContribution ) {
            $vars['dynamic']['employerItem'][] = array( 'TPLVAR_TITLE' => $this->L10n->getContents('LANG_TOTAL_EMPLOYER_CONTRIBUTION'),
                                                        'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
                                                        'TPLVAR_AMOUNT' => number_format( $totalContribution,2 ) );
        }

        $vars['dynamic']['deductionSummary'][] = array( 'TPLVAR_TITLE' => $this->L10n->getContents('LANG_TOTAL_CLAIM'),
                                                        'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
                                                        'TPLVAR_AMOUNT' => number_format( $totalClaim,2 ) );

        $PayrollUserTaxModel = PayrollUserTaxModel::getInstance( );
        $userTaxInfo = $PayrollUserTaxModel->getByPuID( $puID );

        if( sizeof( $userTaxInfo ) ) {
            foreach( $userTaxInfo as $userTax ) {
                $vars['dynamic']['deductionSummary'][] = array( 'TPLVAR_TITLE' => $userTax['remark'],
                                                                'TPLVAR_CURRENCY' => $data['empInfo']['currency'],
                                                                'TPLVAR_AMOUNT' => number_format( $userTax['amount'],2 ) );
            }
        }

        $vars['TPLVAR_CURRENCY'] = $data['empInfo']['currency'];
        $vars['TPLVAR_GROSS_AMOUNT'] = number_format( $summary['gross'],2 );
        $vars['TPLVAR_CLAIM_AMOUNT'] = number_format( $summary['claim'],2 );
        $vars['TPLVAR_NET_AMOUNT'] = number_format( $summary['net'],2 );

        return $this->View->render('markaxis/payroll/processSummary.tpl', $vars );
    }
}
?>