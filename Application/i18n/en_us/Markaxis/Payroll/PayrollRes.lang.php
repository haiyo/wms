<?php
namespace Markaxis\Payroll;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PayrollRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollRes extends Resource {


    // Properties


    /**
     * PayrollRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_PAYROLL_CLAIM'] = 'Payroll &amp; Claim';
        $this->contents['LANG_CPF_SUBMISSION'] = 'CPF Submission';
        $this->contents['LANG_TAX_FILING'] = 'Tax Filing (IRAS)';
        $this->contents['LANG_VIEW_DOWNLOAD_PAYSLIPS'] = 'View My Payslips';
        $this->contents['LANG_PAYROLL_OVERVIEW'] = 'Payroll Overview';
        $this->contents['LANG_PAYROLL_ARCHIVE'] = 'More Payroll Archives';
        $this->contents['LANG_PROCESS_PAYROLL'] = 'Process Payroll';
        $this->contents['LANG_CREATE_NEW_PAY_RUN'] = 'Create New Pay Run';
        $this->contents['LANG_PAYSLIP_RECORDS'] = 'Payslip Records';
        $this->contents['LANG_PAYROLL_SETTINGS'] = 'Payroll Settings';
        $this->contents['LANG_ADD_PAY_CALENDAR'] = 'Add Pay Calendar';
        $this->contents['LANG_WHICH_OFFICE'] = 'Which Office';
        $this->contents['LANG_SELECT_OFFICE'] = 'Select Office';
        $this->contents['LANG_CREATE_NEW_PAY_ITEM'] = 'Create New Pay Item';
        $this->contents['LANG_CREATE_NEW_PAY_CALENDAR'] = 'Create New Pay Calendar';
        $this->contents['LANG_STARTDATE_HELP'] = 'This pay period ends on {endDate} and repeats {payPeriod}';
        $this->contents['LANG_FIRST_PAYMENT_HELP'] = 'Upcoming Payment Dates: {dates}';
        $this->contents['LANG_MY_PAYSLIPS'] = 'My Payslips';
        $this->contents['LANG_UPCOMING'] = 'Upcoming';
        $this->contents['LANG_COMPLETED'] = 'Completed';
        $this->contents['LANG_PENDING'] = 'Pending';
        $this->contents['LANG_NO_DATA'] = 'No Data';
        $this->contents['LANG_VERIFICATION_FAILED'] = 'Verification Failed';
        $this->contents['LANG_NOT_PROCESS_YET'] = 'payroll has not yet been processed.<br />Do you want to process it now?';
        $this->contents['LANG_LETS_DO_IT'] = 'Yes, let\'s do it!';
        $this->contents['LANG_ENTER_PASSWORD'] = 'Please enter your password to continue';
        $this->contents['LANG_CREATE_NEW_TAX_FILING'] = 'Create New Tax Filing';
        $this->contents['LANG_CREATE_AMENDMENT'] = 'Create Amendment';
        $this->contents['LANG_WHAT_IS_AIS'] = 'WHAT IS AUTO-INCLUSION SCHEME(AIS)?';
        $this->contents['LANG_IRAS_FORM'] = 'IRAS Form';
        $this->contents['LANG_SELECT_EMPLOYEE'] = 'Select Employee';
        $this->contents['LANG_DECLARATION_FOR_INDIVIDUAL_EMPLOYEE'] = 'Declaration For Individual Employee (Optional)';
        $this->contents['LANG_FILE_TAX_FOR_YEAR'] = 'File Tax For Year';
        $this->contents['LANG_SELECT_OFFICE'] = 'Select Office';
        $this->contents['LANG_AUTHORIZED_SUBMITTING_PERSONNEL'] = 'Authorized Submitting Personnel';
        $this->contents['LANG_FIRST_NAME_LAST_NAME'] = 'First Name &amp; Last Name';
        $this->contents['LANG_DESIGNATION'] = 'Designation';
        $this->contents['LANG_IDENTITY_TYPE'] = 'Identity Type';
        $this->contents['LANG_IDENTITY_NUMBER'] = 'Identity Number';
        $this->contents['LANG_EMAIL'] = 'Email Address';
        $this->contents['LANG_CONTACT_NUMBER'] = 'Contact Number';
        $this->contents['LANG_TOTAL_EMPLOYER_LEVY'] = 'Total Employer Levy';
        $this->contents['LANG_TOTAL_EMPLOYER_CONTRIBUTION'] = 'Total Employer Contribution';
        $this->contents['LANG_TOTAL_CLAIM'] = 'Total Claim';
        $this->contents['LANG_PAY_PERIOD'] = 'Pay Period';
        $this->contents['LANG_PAYMENT_METHOD'] = 'Payment Method';
        $this->contents['LANG_BANK_NAME'] = 'Bank Name';
        $this->contents['LANG_ACCOUNT_NUMBER'] = 'Account No.';
        $this->contents['LANG_PAYSLIP'] = 'Payslip';
        $this->contents['LANG_NAME'] = 'Name';
        $this->contents['LANG_NEXT_PAYMENT_DATE'] = 'Next Payment Date';
        $this->contents['LANG_PAYMENT_CYCLE'] = 'Payment Cycle';
        $this->contents['LANG_ACTIONS'] = 'Actions';
        $this->contents['LANG_HOW_OFTEN_PAY'] = 'How often will you pay your employees?';
        $this->contents['LANG_PAY_RUN_TITLE'] = 'Pay Run Title';
        $this->contents['LANG_MONTHLY_WEEKLY'] = 'Monthly Full-time Employee, Weekly Part-time Employee';
        $this->contents['LANG_PAYMENT_CYCLE_DATE'] = 'Payment Cycle Date';
        $this->contents['LANG_CANCEL'] = 'Cancel';
        $this->contents['LANG_SUBMIT'] = 'Submit';
        $this->contents['LANG_PAY_CALENDAR'] = 'Pay Calendars';
        $this->contents['LANG_PAY_ITEMS'] = 'Pay Items';
        $this->contents['LANG_EXPENSES_ITEM'] = 'Expenses Item';
        $this->contents['LANG_TAX_RULES'] = 'Tax Rules';
        $this->contents['LANG_PAY_ITEM_TITLE'] = 'Pay Item Title';
        $this->contents['LANG_ORDINARY_WAGE'] = 'Ordinary Wage';
        $this->contents['LANG_DEDUCTION'] = 'Deduction';
        $this->contents['LANG_DEDUCTION_AW'] = 'Deduction AW';
        $this->contents['LANG_ADDITIONAL_WAGE'] = 'Additional Wage';
        $this->contents['LANG_ENTER_PAY_ITEM_TITLE'] = 'Enter a title for this pay item';
        $this->contents['LANG_FORMULA'] = 'Formula';
        $this->contents['LANG_ENTER_FORMULA'] = 'Enter formula (optional)';
        $this->contents['LANG_PAY_ITEM_BELONGS_TO'] = 'This Pay Item Belongs To';
        $this->contents['LANG_NONE'] = 'None';
        $this->contents['LANG_ITEM_TYPE'] = 'Item Type';
        $this->contents['LANG_AMOUNT'] = 'Amount';
        $this->contents['LANG_REMARK'] = 'Remark';

        // Taxes Computing
        $this->contents['LANG_CREATE_NEW_TAX_GROUP'] = 'Create New Tax Group';
        $this->contents['LANG_CREATE_NEW_TAX_RULE'] = 'Create New Tax Rule';
        $this->contents['LANG_NO_TAX'] = 'No Tax';
        $this->contents['LANG_TAX_GROUP_TITLE'] = 'Tax Group Title';
        $this->contents['LANG_ENTER_TAX_GROUP_TITLE'] = 'Enter a title for this group';
        $this->contents['LANG_OFFICE'] = 'Office';
        $this->contents['LANG_DESCRIPTION'] = 'Description';
        $this->contents['LANG_ENTER_TAX_GROUP_DESCRIPTION'] = 'Description for this group (Optional)';
        $this->contents['LANG_PARENT'] = 'Parent';
        $this->contents['LANG_ALLOW_SELECTION'] = 'Allow Selection When Create / Edit Employee';
        $this->contents['LANG_DISPLAY_SUMMARY'] = 'Display On Payroll Summary';
        $this->contents['LANG_TAX_RULE_TITLE'] = 'Tax Rule Title';
        $this->contents['LANG_ENTER_TAX_RULE_TITLE'] = 'Enter a title for this tax rule';
        $this->contents['LANG_APPLY_WHICH_COUNTRY'] = 'Apply To Which Country';
        $this->contents['LANG_BELONG_TO_GROUP'] = 'Belong to Group';
        $this->contents['LANG_SELECT_CRITERIA'] = 'Select Criteria';
        $this->contents['LANG_COMPUTING_VARIABLE'] = 'Computing Variables';
        $this->contents['LANG_AGE'] = 'Age';
        $this->contents['LANG_PAY_ITEM'] = 'Pay Item';
        $this->contents['LANG_ALL_PAY_ITEM'] = 'All Pay Item';
        $this->contents['LANG_TOTAL_WORKFORCE'] = 'Total Workforce';
        $this->contents['LANG_OTHER_EMPLOYEE_VARIABLES'] = 'Other Employee Variables';
        $this->contents['LANG_COMPETENCY'] = 'Competency';
        $this->contents['LANG_CONTRACT_TYPE'] = 'Contract Type';
        $this->contents['LANG_RACE'] = 'Race';
        $this->contents['LANG_GENDER'] = 'Gender';
        $this->contents['LANG_COMPUTING'] = 'Computing';
        $this->contents['LANG_LESS_THAN'] = 'Less Than';
        $this->contents['LANG_GREATER_THAN'] = 'Greater Than';
        $this->contents['LANG_LESS_THAN_OR_EQUAL'] = 'Less Than Or Equal';
        $this->contents['LANG_LESS_THAN_OR_EQUAL_AND_CAPPED'] = 'Less Than Or Equal And Capped At';
        $this->contents['LANG_GREATER_THAN_OR_EQUAL'] = 'Greater Than Or Equal';
        $this->contents['LANG_EQUAL'] = 'Equal';
        $this->contents['LANG_AMOUNT_TYPE'] = 'Amount Type';
        $this->contents['LANG_PERCENTAGE'] = 'Percentage';
        $this->contents['LANG_FIXED_INTEGER'] = 'Fixed / Integer';
        $this->contents['LANG_VALUE'] = 'Value';
        $this->contents['LANG_SELECT_PAY_ITEM'] = 'Select Pay Item';
        $this->contents['LANG_CUSTOM_FORMULA'] = 'Custom Formula';
        $this->contents['LANG_ENTER_COMPETENCIES'] = 'Enter Competencies';
        $this->contents['LANG_TYPE_ENTER_NEW_COMPETENCY'] = 'Type and press Enter to add new competency';
        $this->contents['LANG_ENTER_SKILLSETS_OR_KNOWLEDGE'] = 'Enter skillsets or knowledge';
        $this->contents['LANG_SELECT_CONTRACT_TYPE'] = 'Select Contract Type';
        $this->contents['LANG_SELECT_DESIGNATION'] = 'Select Designation';
        $this->contents['LANG_SELECT_RACE'] = 'Select Race';
        $this->contents['LANG_SELECT_GENDER'] = 'Select Gender';
        $this->contents['LANG_APPLY_ABOVE_CRITERIA_AS'] = 'Apply above criteria as';
        $this->contents['LANG_DEDUCTION_FROM_ORDINARY'] = 'Deduction From Ordinary Wage';
        $this->contents['LANG_DEDUCTION_FROM_ADDITIONAL'] = 'Deduction From Additional Wage';
        $this->contents['LANG_EMPLOYER_CONTRIBUTION'] = 'Employer Contribution';
        $this->contents['LANG_SKILL_DEVELOPMENT_LEVY'] = 'Skill Development Levy';
        $this->contents['LANG_FOREIGN_WORKER_LEVY'] = 'Foreign Worker Levy';
        $this->contents['LANG_TYPE_OF_VALUE'] = 'Type of Value';
        $this->contents['LANG_TOTAL_GROSS'] = 'Total Gross';
        $this->contents['LANG_TOTAL_NET_PAYABLE'] = 'Total Net Payable';
        $this->contents['LANG_PAYMENT'] = 'Payment';
        $this->contents['LANG_PROCESS_PERIOD'] = 'Process Period';
        $this->contents['LANG_SELECT_EMPLOYEE_TO_PROCESS'] = 'Select Employee to Process Payroll';
        $this->contents['LANG_EMPLOYEE_ID'] = 'Employee ID';
        $this->contents['LANG_EMPLOYEE'] = 'Employee';
        $this->contents['LANG_EMPLOYMENT_STATUS'] = 'Employment Status';
        $this->contents['LANG_SUMMARY'] = 'Summary';
        $this->contents['LANG_GROSS'] = 'Gross';
        $this->contents['LANG_CLAIM'] = 'Claim';
        $this->contents['LANG_LEVY'] = 'Levy';
        $this->contents['LANG_CONTRIBUTION'] = 'Contribution';
        $this->contents['LANG_NET'] = 'Net';
        $this->contents['LANG_TOTAL'] = 'Total';
        $this->contents['LANG_ACCOUNT_PAYSLIP_RELEASE'] = 'Account &amp; Payslip Release';
        $this->contents['LANG_ACCOUNT_DETAILS'] = 'Account Details';
        $this->contents['LANG_PAYABLE'] = 'Payable';
        $this->contents['LANG_RELEASED'] = 'Released';
        $this->contents['LANG_PAYMENT_METHOD'] = 'Payment Method';

        // Overview
        $this->contents['LANG_WORK_DAYS'] = 'Work Days';
        $this->contents['LANG_AVG_SALARY'] = 'Avg. Salary';
        $this->contents['LANG_AVG_CONTRIBUTIONS'] = 'Avg. Contributions';
        $this->contents['LANG_SALARIES_PAID'] = 'SALARIES PAID';
        $this->contents['LANG_CLAIMS_PAID'] = 'CLAIMS PAID';
        $this->contents['LANG_LEVIES_PAID'] = 'LEVIES PAID';
        $this->contents['LANG_VIEW_FINALIZED_PAYROLL'] = 'View Finalized Payroll';
        $this->contents['LANG_VERIFY_CREDENTIAL'] = 'Verify Credential';
        $this->contents['LANG_ENTER_PASSWORD_CONTINUE'] = 'Enter your password to continue';
        $this->contents['LANG_UNLOCK'] = 'Unlock';
    }
}
?>