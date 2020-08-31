<?php
namespace Markaxis\Employee;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: EmployeeRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AdditionalRes extends Resource {


    // Properties


    /**
     * EmployeeRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_ADDITIONAL_INFO'] = 'Additional Info';
        $this->contents['LANG_ECONTACT_INFO'] = 'If have any children, be sure to add them in contact for Leave Entitlement purposes.';
        $this->contents['LANG_SELECT_TAX_GROUP'] = 'Select Tax Group';
        $this->contents['LANG_SELECT_PAYROLL_CALENDAR'] = 'Select Payroll Calendar';
        $this->contents['LANG_SELECT_PAYMENT_METHOD'] = 'Select Payment Method';
        $this->contents['LANG_SELECT_BANK'] = 'Select Bank';
        $this->contents['LANG_SELECT_LEAVE_TYPE'] = 'Select Leave Type';
        $this->contents['LANG_FINANCE_LEAVE'] = 'Finance &amp; Leave';
        $this->contents['LANG_ASSIGN_PAYROLL_CALENDAR'] = 'Assign Payroll Calendar';
        $this->contents['LANG_ASSIGN_TAX_GROUP'] = 'Assign Tax Group';
        $this->contents['LANG_ASSIGN_LEAVE_TYPE'] = 'Assign Leave Type';
        $this->contents['LANG_EMPLOYEE_PAYMENT_DETAILS'] = 'Employee Payment Details';
        $this->contents['LANG_PAYMENT_METHOD'] = 'Payment Method';
        $this->contents['LANG_BANK'] = 'Bank';
        $this->contents['LANG_BANK_ACCOUNT_NUMBER'] = 'Bank Account Number';
        $this->contents['LANG_BANK_CODE'] = 'Bank Code';
        $this->contents['LANG_BANK_BRANCH_CODE'] = 'Bank Branch Code';
        $this->contents['LANG_BANK_ACCOUNT_NAME'] = 'Bank Account Holder\'s Name';
        $this->contents['LANG_BANK_SWIFT_CODE'] = 'Bank Swift Code';
    }
}
?>