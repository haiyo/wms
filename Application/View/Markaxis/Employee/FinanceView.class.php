<?php
namespace Markaxis\Employee;
use \Aurora\AuroraView, \Aurora\Form\SelectListView;
use \Aurora\Component\PaymentMethodModel, \Aurora\Component\BankModel as AuroraBankModel;
use \Markaxis\Employee\PayrollModel as EmployeePayrollModel;
use \Markaxis\Employee\TaxModel as EmployeeTaxModel;
use \Markaxis\Employee\LeaveTypeModel as EmployeeLeaveTypeModel;
use \Markaxis\Payroll\CalendarModel as PayrollCalendarModel;
use \Markaxis\Payroll\TaxGroupModel as PayrollTaxGroupModel;
use \Markaxis\Leave\TypeModel;
use \Library\IO\File;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: FinanceView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class FinanceView extends AuroraView {


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
        parent::__construct( );

        $this->Registry = Registry::getInstance();
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Employee/AdditionalRes');

        File::import( MODEL . 'Markaxis/Employee/FinanceModel.class.php' );
        $this->FinanceModel = FinanceModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderAdd( ) {
        $this->info = $this->FinanceModel->getInfo( );
        return $this->renderForm( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderEdit( $userID ) {
        if( $userID ) {
            File::import(MODEL . 'Markaxis/Employee/BankModel.class.php');
            $BankModel = BankModel::getInstance( );
            $BankModel->loadInfo( $userID );

            File::import(MODEL . 'Markaxis/Employee/PayrollModel.class.php');
            $PayrollModel = EmployeePayrollModel::getInstance( );
            $PayrollModel->loadInfo( $userID );

            File::import(MODEL . 'Markaxis/Employee/TaxModel.class.php');
            $TaxModel = EmployeeTaxModel::getInstance( );
            $TaxModel->getListByUserID( $userID );

            File::import(MODEL . 'Markaxis/Employee/LeaveTypeModel.class.php');
            $LeaveTypeModel = EmployeeLeaveTypeModel::getInstance( );
            $LeaveTypeModel->getListByUserID( $userID );
        }
        return $this->renderForm( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function renderForm( ) {
        File::import(MODEL . 'Markaxis/Employee/BankModel.class.php');
        $BankModel = BankModel::getInstance( );
        $bankInfo = $BankModel->getInfo( );

        File::import(MODEL . 'Markaxis/Employee/PayrollModel.class.php');
        $PayrollModel = EmployeePayrollModel::getInstance( );
        $payrollInfo = $PayrollModel->getInfo( );

        File::import(MODEL . 'Markaxis/Employee/TaxModel.class.php');
        $TaxModel = EmployeeTaxModel::getInstance( );
        $taxInfo = $TaxModel->getInfo( );

        File::import(MODEL . 'Markaxis/Employee/LeaveTypeModel.class.php');
        $LeaveTypeModel = EmployeeLeaveTypeModel::getInstance( );
        $leaveTypeInfo = $LeaveTypeModel->getInfo( );

        File::import( MODEL . 'Markaxis/Payroll/CalendarModel.class.php' );
        $CalendarModel = PayrollCalendarModel::getInstance( );

        File::import( VIEW . 'Aurora/Form/SelectListView.class.php' );
        $SelectListView = new SelectListView( );
        $payrollCalList = $SelectListView->build( 'pcID', $CalendarModel->getList( ), $payrollInfo['pcID'], 'Select Payroll Calendar' );

        File::import( MODEL . 'Aurora/Component/PaymentMethodModel.class.php' );
        $PaymentMethodModel = PaymentMethodModel::getInstance( );
        $pmID = $bankInfo['pmID'] ? $bankInfo['pmID'] : '';
        $SelectListView->setClass( 'paymentMethodList' );
        $paymentMethodList = $SelectListView->build( 'pmID',  $PaymentMethodModel->getList( ), $pmID, 'Select Payment Method' );

        File::import( MODEL . 'Aurora/Component/BankModel.class.php' );
        $BankModel = AuroraBankModel::getInstance( );
        $bkID = $bankInfo['bkID'] ? $bankInfo['bkID'] : '';
        $bankList = $SelectListView->build( 'bank',  $BankModel->getList( ), $bkID, 'Select Bank' );

        File::import( MODEL . 'Markaxis/Payroll/TaxGroupModel.class.php' );
        $TaxGroupModel = PayrollTaxGroupModel::getInstance( );

        File::import( MODEL . 'Markaxis/Leave/TypeModel.class.php' );
        $TypeModel = TypeModel::getInstance( );

        $SelectListView->isMultiple( true );
        $SelectListView->includeBlank( false );
        $SelectListView->setClass( '' );

        $taxGroup = isset( $taxInfo['tgID'] ) ? explode(',', $taxInfo['tgID'] ) : '';
        $taxGroupList = $SelectListView->build( 'tgID', $TaxGroupModel->getList( ), $taxGroup, 'Select Tax Group' );

        $leaveType = isset( $leaveTypeInfo['ltID'] ) ? explode(',', $leaveTypeInfo['ltID'] ) : '';
        $leaveTypeList = $SelectListView->build( 'ltID', $TypeModel->getList( ), $leaveType, 'Select Leave Type' );

        $vars = array_merge( $this->L10n->getContents( ),
            array( 'TPLVAR_BANK_NUMBER' => $bankInfo['bankNumber'],
                   'TPLVAR_BANK_CODE' => $bankInfo['bankCode'],
                   'TPLVAR_BRANCH_CODE' => $bankInfo['branchCode'],
                   'TPLVAR_BANK_HOLDER_NAME' => $bankInfo['bankHolderName'],
                   'TPLVAR_SWIFT_CODE' => $bankInfo['swiftCode'],
                   'TPLVAR_BRANCH_NAME' => $bankInfo['branchName'],
                   'TPL_PAYROLL_CAL_LIST' => $payrollCalList,
                   'TPL_TAX_GROUP_LIST' => $taxGroupList,
                   'TPL_LEAVE_TYPE_LIST' => $leaveTypeList,
                   'TPL_PAYMENT_METHOD_LIST' => $paymentMethodList,
                   'TPL_BANK_LIST' => $bankList ) );

        return $this->render( 'markaxis/employee/financeForm.tpl', $vars );
    }
}
?>