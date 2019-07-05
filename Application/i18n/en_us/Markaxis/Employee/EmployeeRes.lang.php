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
        $this->contents['LANG_EMPLOYEE_DIRECTORY'] = 'Employee Directory';
        $this->contents['LANG_ADD_NEW_EMPLOYEE'] = 'Add New Employee';
        $this->contents['LANG_EDIT_EMPLOYEE_INFO'] = 'Edit Employee Info';
        $this->contents['LANG_EMPLOYEE_TIMESHEET'] = 'Employee Timesheet';
        $this->contents['LANG_EMPLOYEE_SETTINGS'] = 'Employee Settings';
        $this->contents['LANG_EMPLOYEE'] = 'Employee';
        $this->contents['LANG_EMPLOYEE_ID'] = 'Employee ID';
        $this->contents['LANG_DESIGNATION'] = 'Designation';
        $this->contents['LANG_DEPARTMENT'] = 'Department';
        $this->contents['LANG_CONTRACT_TYPE'] = 'Contract Type';
        $this->contents['LANG_WORK_PASS'] = 'Work Pass';
        $this->contents['LANG_EMPLOYMENT_START_DATE'] = 'Employment Start Date';
        $this->contents['LANG_EMPLOYMENT_END_DATE'] = 'Employment End Date';
        $this->contents['LANG_EMPLOYMENT_CONFIRM_DATE'] = 'Employment Confirmation Date';
        $this->contents['LANG_DIFF_YEAR'] = 'yr';
        $this->contents['LANG_DIFF_MONTH'] = 'mth';
        $this->contents['LANG_DIFF_DAY'] = 'd';
        $this->contents['LANG_COMPETENCY_INFO'] = 'Add multiple competencies for employee eligibility for Courses and/or to
                                                   set criteria for other complicated Tax requirement by the Government
                                                   when you are doing Payroll for this employee. For e.g: NTS and PRC – higher-skilled,
                                                   on MYE.';
    }
}
?>