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
        $this->contents = array( );
        $this->contents['LANG_PAYROLL_CLAIM'] = 'Payroll &amp; Claim';
        $this->contents['LANG_CPF_SUBMISSION'] = 'CPF Submission';
        $this->contents['LANG_TAX_FILING'] = 'Tax Filing (IRAS)';
        $this->contents['LANG_VIEW_DOWNLOAD_PAYSLIPS'] = 'View &amp; Download Payslips';
        $this->contents['LANG_PAYROLL_OVERVIEW'] = 'Payroll Overview';
        $this->contents['LANG_PROCESS_PAYROLL'] = 'Process Payroll';
        $this->contents['LANG_CREATE_NEW_PAY_RUN'] = 'Create New Pay Run';
        $this->contents['LANG_PAYSLIP_RECORDS'] = 'Payslip Records';
        $this->contents['LANG_PAYROLL_SETTINGS'] = 'Payroll Settings';
        $this->contents['LANG_ADD_PAY_CALENDAR'] = 'Add Pay Calendar';
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
        $this->contents['LANG_NOT_PROCESS_YET'] = 'payroll have not yet been processed.<br />Do you want to process it now?';
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
    }
}
?>