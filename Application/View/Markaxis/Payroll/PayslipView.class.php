<?php
namespace Markaxis\Payroll;
use \Markaxis\Company\CompanyModel;
use \Markaxis\Expense\ExpenseModel, \Markaxis\Leave\LeaveApplyModel, \Markaxis\Expense\ClaimModel;
use \Aurora\Admin\AdminView;
use \Library\Util\Money;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PayrollView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayslipView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $PayslipModel;


    /**
    * PayslipView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->PayslipModel = PayslipModel::getInstance( );

        $this->View->setJScript( array( 'plugins/tables/datatables' => array( 'datatables.min.js', 'checkboxes.min.js'),
                                        'markaxis' => 'payslip.js',
                                        'locale' => $this->L10n->getL10n( ) ) );
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderPayslipList( ) {
        $this->View->setTitle( $this->L10n->getContents('LANG_VIEW_DOWNLOAD_PAYSLIPS') );
        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'icon-download',
                                            'text' => $this->L10n->getContents('LANG_VIEW_DOWNLOAD_PAYSLIPS') ) );

        $vars = array_merge( $this->L10n->getContents( ), array( ) );

        $this->View->printAll( $this->View->render( 'markaxis/payroll/payslipList.tpl', $vars ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSlip( $data, $password ) {
        $CompanyModel = new CompanyModel( );
        $companyInfo = $CompanyModel->loadInfo( );

        $logoURL = $CompanyModel->getLogo('slip_uID' );
        $image = file_get_contents( $logoURL );
        $uri = "data:image/png;base64," . base64_encode( $image );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_LOGO' => $uri,
                       'TPLVAR_COMPANY_NAME' => $companyInfo['name'],
                       'TPLVAR_NAME' => $data['empInfo']['name'],
                       'TPLVAR_DEPARTMENT' => $data['empInfo']['department'],
                       'TPLVAR_DESIGNATION' => $data['empInfo']['designation'],
                       'TPLVAR_START_DATE' => $data['empInfo']['startDate']->format('Y-m-d'),
                       'TPLVAR_CONTRACT_TYPE' => $data['empInfo']['contractType'],
                       'TPLVAR_PROCESS_DATE' => $data['payrollInfo']['endDate'],
                       'TPLVAR_PAY_PERIOD' => $data['payrollInfo']['endDate'] ) );

        $vars['dynamic']['address']   = false;
        $vars['dynamic']['regNumber'] = false;
        $vars['dynamic']['phone']     = false;
        $vars['dynamic']['website']   = false;

        if( $companyInfo['address'] ) {
            $vars['dynamic']['address'][] = array( 'TPLVAR_COMPANY_ADDRESS' => $companyInfo['address'] );
        }

        if( $companyInfo['regNumber'] ) {
            $vars['dynamic']['regNumber'][] = array( 'TPLVAR_COMPANY_REGNUMBER' => $companyInfo['regNumber'] );
        }

        if( $companyInfo['phone'] ) {
            $vars['dynamic']['phone'][] = array( 'TPLVAR_COMPANY_PHONE' => $companyInfo['phone'] );
        }

        if( $companyInfo['website'] ) {
            $vars['dynamic']['website'][] = array( 'TPLVAR_COMPANY_WEBSITE' => $companyInfo['website'] );
        }

        $ItemModel = ItemModel::getInstance( );
        $ExpenseModel = ExpenseModel::getInstance( );
        $itemList = $ItemModel->getList( );
        $expenseList = $ExpenseModel->getList( );

        if( isset( $data['itemRow'] ) && is_array( $data['itemRow'] ) ) {
            foreach( $data['itemRow'] as $item ) {
                if( isset( $item['piID'] ) ) {
                    $title = $itemList[$item['piID']]['title'];
                }
                else {
                    $title = $expenseList[$item['eiID']];
                }

                $vars['dynamic']['item'][] = array( 'TPLVAR_ID' => '',
                                                    'TPLVAR_HIDDEN_ID' => '',
                                                    'TPLVAR_DEDUCTION' => '',
                                                    'TPLVAR_CURRENCY' => $data['office']['currencyCode'] . $data['office']['currencySymbol'],
                                                    'TPLVAR_AMOUNT' => $data['office']['currencyCode'] .
                                                                       $data['office']['currencySymbol'] . Money::format( $item['amount'] ),
                                                    'TPLVAR_TITLE' => $title,
                                                    'TPLVAR_REMARK' => $item['remark'] );
            }
        }

        $SummaryModel = SummaryModel::getInstance( );
        $summary = $SummaryModel->getByPuID( $data['payrollUser']['puID'] );

        if( isset( $data['userTax'] ) ) {
            foreach( $data['userTax'] as $userTax ) {
                $vars['dynamic']['deductionSummary'][] = array( 'TPLVAR_TITLE' => $userTax['title'],
                                                                'TPLVAR_CURRENCY' => $data['office']['currencyCode'] . $data['office']['currencySymbol'],
                                                                'TPLVAR_AMOUNT' => Money::format( $userTax['amount'] ),
                                                                'TPLVAR_SHOW_TIP' => 'hide',
                                                                'TPLVAR_REMARK' => $userTax['remark'] );
            }
        }

        if( $summary['claim'] && $summary['claim'] > 0  ) {
            $vars['dynamic']['deductionSummary'][] = array( 'TPLVAR_TITLE' => $this->L10n->getContents('LANG_TOTAL_CLAIM'),
                                                            'TPLVAR_CURRENCY' => $data['office']['currencyCode'] . $data['office']['currencySymbol'],
                                                            'TPLVAR_AMOUNT' => Money::format( $summary['claim'] ),
                                                            'TPLVAR_SHOW_TIP' => 'hide',
                                                            'TPLVAR_REMARK' => '' );
        }

        $vars['TPLVAR_CURRENCY'] = $data['office']['currencyCode'] . $data['office']['currencySymbol'];
        $vars['TPLVAR_GROSS_AMOUNT'] = Money::format( $summary['gross'] );
        $vars['TPLVAR_NET_AMOUNT'] = Money::format( $summary['net'] );

        $html = $this->View->renderHeader( );
        $html .= $this->View->render( 'markaxis/payroll/slip.tpl', $vars );

        require_once LIB . 'vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf( );
        $mpdf->SetProtection( array( 'print-highres' ), $password );
        $mpdf->WriteHTML( $html );
        $mpdf->Output('payslip-' . $data['payrollInfo']['endDate'] . '.pdf','I' );
    }
}
?>