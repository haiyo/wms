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
        $this->contents['LANG_PAYROLL_BENEFITS'] = 'Payroll &amp; Benefits';
        $this->contents['LANG_VIEW_DOWNLOAD_PAYSLIPS'] = 'View &amp; Download Payslips';
        $this->contents['LANG_PAYROLL_OVERVIEW'] = 'Payroll Overview';
        $this->contents['LANG_PROCESS_PAYROLL'] = 'Process Payroll';
        $this->contents['LANG_CREATE_NEW_PAY_RUN'] = 'Create New Pay Run';
        $this->contents['LANG_PAYSLIP_RECORDS'] = 'Payslip Records';
        $this->contents['LANG_PAYROLL_SETTINGS'] = 'Payroll Settings';
        $this->contents['LANG_ADD_PAY_CALENDAR'] = 'Add Pay Calendar';
        $this->contents['LANG_CREATE_NEW_PAY_CALENDAR'] = 'Create New Pay Calendar';
        $this->contents['LANG_STARTDATE_HELP'] = 'This pay period ends on {endDate} and repeats {payPeriod}';
        $this->contents['LANG_FIRST_PAYMENT_HELP'] = 'Upcoming Payment Dates: {dates}';
    }
}
?>