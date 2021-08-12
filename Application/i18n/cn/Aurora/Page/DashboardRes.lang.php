<?php
namespace Aurora\Page;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: DashboardRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DashboardRes extends Resource {


    /**
     * DashboardRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_DASHBOARD'] = 'Dashboard';
        $this->contents['LANG_HELLO'] = 'hello';
        $this->contents['LANG_WELCOME'] = 'Welcome';
        $this->contents['LANG_DASHBOARD_INTRO'] = 'You\'re looking at HRMS, your new tool for work. Here\'s a quick look at some of the things you can do here in HRMS.';
        $this->contents['LANG_MY_LEAVE'] = 'My Leaves';
        $this->contents['LANG_LEAVE_INTRO'] = 'Check your leave balance and history';
        $this->contents['LANG_MY_CALENDAR'] = 'My Calendar';
        $this->contents['LANG_CALENDAR_INTRO'] = 'Find out any events or planned leaves';
        $this->contents['LANG_STAFF_DIRECTORY'] = 'Staff Directory';
        $this->contents['LANG_STAFF_INTRO'] = 'Search for coworkers and contact';
        $this->contents['LANG_EXPENSES_CLAIMS'] = 'Expenses Claim';
        $this->contents['LANG_CLAIMS_INTRO'] = 'Submit claims or check approval status';
        $this->contents['LANG_MY_PAYSLIP'] = 'My Payslips';
        $this->contents['LANG_PAYSLIP_INTRO'] = 'View history or download payslips';
        $this->contents['LANG_LOA'] = 'Letter of Appointment';
        $this->contents['LANG_LOA_INTRO'] = 'Access your Letter of Appointment';
        $this->contents['LANG_PENDING_ACTIONS'] = 'Pending Action(s)';
        $this->contents['LANG_NO_PENDING_ACTION'] = 'You have no pending action at the moment...';
        $this->contents['LANG_LATEST_REQUESTS'] = 'Latest Request(s)';
        $this->contents['LANG_NO_LATEST_REQUEST'] = 'You have not made any request at the moment...';
        $this->contents['LANG_DAYS_AVAILABLE'] = 'Days Available';
        $this->contents['LANG_APPLY_LEAVE_NOW'] = 'Apply Leave Now';
    }
}
?>