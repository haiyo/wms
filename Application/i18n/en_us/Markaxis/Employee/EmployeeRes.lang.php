<?php
namespace Markaxis\Employee;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: EmployeeRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EmployeeRes extends Resource {


    // Properties


    /**
     * EmployeeRes Constructor
     * @return void
     */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_STAFF_DIRECTORY'] = 'Staff Directory';
        $this->contents['LANG_ADD_NEW_EMPLOYEE'] = 'Add New Employee';
        $this->contents['LANG_EDIT_EMPLOYEE_INFO'] = 'Edit Employee Info';
        $this->contents['LANG_EMPLOYEE_TIMESHEET'] = 'Employee Timesheet';
        $this->contents['LANG_EMPLOYEE_SETTINGS'] = 'Employee Settings';
        $this->contents['LANG_COMPETENCY_INFO'] = 'Add multiple competencies for employee eligibility for Courses and/or to
                                                   set criteria for other complicated Tax requirement by the Government
                                                   when you are doing Payroll for this employee. For e.g: NTS and PRC – higher-skilled,
                                                   on MYE.';
    }
}
?>