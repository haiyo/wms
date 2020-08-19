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
        return $this->renderForm( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderForm( ) {
        $BankModel = BankModel::getInstance( );
        $bankInfo = $BankModel->getInfo( );

        $PayrollModel = EmployeePayrollModel::getInstance( );
        $payrollInfo = $PayrollModel->getInfo( );

        $LeaveTypeModel = LeaveTypeModel::getInstance( );
        $leaveTypeInfo = $LeaveTypeModel->getInfo( );

        $CalendarModel = CalendarModel::getInstance( );

        $SelectListView = new SelectListView( );
        $pcID = isset( $payrollInfo['pcID'] ) ? $payrollInfo['pcID'] : '';
        $payrollCalList = $SelectListView->build( 'pcID', $CalendarModel->getList( ), $pcID, 'Select Payroll Calendar' );

        $EmployeeModel = EmployeeModel::getInstance();
        $empInfo = $EmployeeModel->getInfo( );

        $PaymentMethodModel = PaymentMethodModel::getInstance( );
        $pmID = isset( $empInfo['paymentMethodID'] ) ? $empInfo['paymentMethodID'] : '';
        $SelectListView->setClass( 'paymentMethodList' );
        $paymentMethodList = $SelectListView->build( 'paymentMethod',  $PaymentMethodModel->getList( ), $pmID, 'Select Payment Method' );

        $BankModel = AuroraBankModel::getInstance( );
        $bkID = isset( $bankInfo['bkID'] ) ? $bankInfo['bkID'] : '';
        $bankList = $SelectListView->build( 'bank',  $BankModel->getList( ), $bkID, 'Select Bank' );

        $TaxGroupModel = TaxGroupModel::getInstance( );
        $TypeModel = TypeModel::getInstance( );

        $SelectListView->isMultiple( true );
        $SelectListView->includeBlank( false );
        $SelectListView->setClass( '' );

        $TaxModel = TaxModel::getInstance( );
        $taxInfo = $TaxModel->getInfo( );

        $taxGroup = isset( $taxInfo['tgID'] ) ? explode(',', $taxInfo['tgID'] ) : '';
        $taxGroupList = $SelectListView->build( 'tgID', $TaxGroupModel->getList( true ), $taxGroup, 'Select Tax Group' );

        $leaveType = isset( $leaveTypeInfo['ltID'] ) ? explode(',', $leaveTypeInfo['ltID'] ) : '';
        $leaveTypeList = $SelectListView->build( 'ltID', $TypeModel->getList( ), $leaveType, 'Select Leave Type' );

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