<?php
namespace Markaxis\Employee;
use \Aurora\Admin\AdminView, \Aurora\Form\SelectListView;
use \Aurora\Component\PaymentMethodModel, \Aurora\Component\BankModel as AuroraBankModel;
use \Markaxis\Employee\PayrollModel as EmployeePayrollModel;
use \Markaxis\Payroll\CalendarModel;
use \Markaxis\Payroll\TaxGroupModel;
use \Markaxis\Leave\TypeModel;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: FinanceView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class FinanceView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $FinanceModel;


    /**
     * FinanceView Constructor
     * @return void
     */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Employee/AdditionalRes');

        $this->FinanceModel = FinanceModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderTaxGroupList( $userID, $oID ) {
        $TaxGroupModel = TaxGroupModel::getInstance( );

        $SelectListView = new SelectListView( );
        $SelectListView->isMultiple( true );
        $SelectListView->includeBlank( false );
        $SelectListView->setClass( '' );

        $TaxModel = TaxModel::getInstance( );
        $taxInfo = $TaxModel->getListByUserID( $userID );

        $taxGroup = isset( $taxInfo['tgID'] ) ? explode(',', $taxInfo['tgID'] ) : '';
        return $SelectListView->build( 'tgID', $TaxGroupModel->getListByOfficeID( $oID ), $taxGroup,
                                        $this->L10n->getContents('LANG_SELECT_TAX_GROUP') );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderAdd( ) {
        $this->info = $this->FinanceModel->getInfo( );
        return $this->renderForm( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderEdit( $userID ) {
        if( $userID ) {
            $BankModel = BankModel::getInstance( );
            $BankModel->loadInfo( $userID );

            $PayrollModel = EmployeePayrollModel::getInstance( );
            $PayrollModel->loadInfo( $userID );

            $TaxModel = TaxModel::getInstance( );
            $TaxModel->getListByUserID( $userID );

            $LeaveTypeModel = LeaveTypeModel::getInstance( );
            $LeaveTypeModel->getltIDByUserID( $userID );
        }
        return $this->renderForm( $userID );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderForm( $userID=0 ) {
        $BankModel = BankModel::getInstance( );
        $bankInfo = $BankModel->getInfo( );

        $PayrollModel = EmployeePayrollModel::getInstance( );
        $payrollInfo = $PayrollModel->getInfo( );

        $LeaveTypeModel = LeaveTypeModel::getInstance( );
        $leaveTypeInfo = $LeaveTypeModel->getInfo( );

        $CalendarModel = CalendarModel::getInstance( );

        $SelectListView = new SelectListView( );
        $pcID = isset( $payrollInfo['pcID'] ) ? $payrollInfo['pcID'] : '';
        $payrollCalList = $SelectListView->build('pcID', $CalendarModel->getList( ), $pcID,
                                                  $this->L10n->getContents('LANG_SELECT_PAYROLL_CALENDAR') );

        $paymentMethodID = $officeID = '';

        if( $userID ) {
            $EmployeeModel = EmployeeModel::getInstance();
            $empInfo = $EmployeeModel->getFieldByUserID( $userID, 'officeID, paymentMethodID' );
            $paymentMethodID = $empInfo['paymentMethodID'];
            $officeID = $empInfo['officeID'];
        }


        $PaymentMethodModel = PaymentMethodModel::getInstance( );
        $pmID = $paymentMethodID ? $paymentMethodID : '';
        $SelectListView->setClass( 'paymentMethodList' );
        $paymentMethodList = $SelectListView->build('paymentMethod', $PaymentMethodModel->getList( ), $pmID,
                                                     $this->L10n->getContents('LANG_SELECT_PAYMENT_METHOD') );

        $BankModel = AuroraBankModel::getInstance( );
        $bkID = isset( $bankInfo['bkID'] ) ? $bankInfo['bkID'] : '';
        $bankList = $SelectListView->build( 'bank', $BankModel->getList( ), $bkID, $this->L10n->getContents('LANG_SELECT_BANK') );

        $TaxGroupModel = TaxGroupModel::getInstance( );
        $TypeModel = TypeModel::getInstance( );

        $SelectListView->isMultiple( true );
        $SelectListView->includeBlank( false );
        $SelectListView->setClass( '' );

        $TaxModel = TaxModel::getInstance( );
        $taxInfo = $TaxModel->getInfo( );

        $taxGroup = isset( $taxInfo['tgID'] ) ? explode(',', $taxInfo['tgID'] ) : '';
        $taxGroupList = $SelectListView->build( 'tgID', $TaxGroupModel->getListByOfficeID( $officeID ), $taxGroup,
                                                $this->L10n->getContents('LANG_SELECT_TAX_GROUP') );

        $leaveType = isset( $leaveTypeInfo['ltID'] ) ? explode(',', $leaveTypeInfo['ltID'] ) : '';
        $leaveTypeList = $SelectListView->build('ltID', $TypeModel->getList( ), $leaveType,
                                                 $this->L10n->getContents('LANG_SELECT_LEAVE_TYPE') );

        $vars = array_merge( $this->L10n->getContents( ),
            array( 'TPLVAR_BANK_NUMBER' => isset( $bankInfo['number'] ) ? $bankInfo['number'] : '',
                'TPLVAR_BANK_CODE' => isset( $bankInfo['code'] ) ? $bankInfo['code'] : '',
                'TPLVAR_BANK_BRANCH_CODE' => isset( $bankInfo['branchCode'] ) ? $bankInfo['branchCode'] : '',
                'TPLVAR_BANK_HOLDER_NAME' => isset( $bankInfo['holderName'] ) ? $bankInfo['holderName'] : '',
                'TPLVAR_SWIFT_CODE' => isset( $bankInfo['swiftCode'] ) ? $bankInfo['swiftCode'] : '',
                'TPL_PAYROLL_CAL_LIST' => $payrollCalList,
                'TPL_TAX_GROUP_LIST' => $taxGroupList,
                'TPL_LEAVE_TYPE_LIST' => $leaveTypeList,
                'TPL_PAYMENT_METHOD_LIST' => $paymentMethodList,
                'TPL_BANK_LIST' => $bankList ) );

        return $this->View->render( 'markaxis/employee/financeForm.tpl', $vars );
    }
}
?>