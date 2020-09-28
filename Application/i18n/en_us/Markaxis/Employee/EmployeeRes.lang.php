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
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_EMPLOYEE_DIRECTORY'] = 'Employee Directory';
        $this->contents['LANG_ADD_NEW_EMPLOYEE'] = 'Add New Employee';
        $this->contents['LANG_EDIT_EMPLOYEE_INFO'] = 'Edit Employee Info';
        $this->contents['LANG_EDIT_PROFILE'] = 'Edit Profile';
        $this->contents['LANG_EMPLOYEE_TIMESHEET'] = 'Employee Timesheet';
        $this->contents['LANG_EMPLOYEE_SETTINGS'] = 'Employee Settings';
        $this->contents['LANG_EMPLOYEE'] = 'Employee';
        $this->contents['LANG_EMPLOYEE_ID'] = 'Employee ID';
        $this->contents['LANG_DESIGNATION'] = 'Designation';
        $this->contents['LANG_DEPARTMENT'] = 'Department';
        $this->contents['LANG_MORE_DEPARTMENTS'] = 'More Departments';
        $this->contents['LANG_CONTRACT_TYPE'] = 'Contract Type';
        $this->contents['LANG_WORK_PASS'] = 'Work Pass';
        $this->contents['LANG_EMPLOYMENT_START_DATE'] = 'Employment Start Date';
        $this->contents['LANG_EMPLOYMENT_START'] = 'Employment Start';
        $this->contents['LANG_EMPLOYMENT_END_DATE'] = 'Employment End Date';
        $this->contents['LANG_EMPLOYMENT_CONFIRM_DATE'] = 'Employment Confirmation Date';
        $this->contents['LANG_EMPLOYMENT_CONFIRM'] = 'Employment Confirmation';
        $this->contents['LANG_SEARCH_NAME_EMAIL'] = 'Search Name or Email';
        $this->contents['LANG_FILTER_BY_DESIGNATION'] = 'Filter By Designation';
        $this->contents['LANG_FILTER_BY_DEPARTMENT'] = 'Filter By Department';
        $this->contents['LANG_DIFF_YEAR'] = 'yr';
        $this->contents['LANG_DIFF_MONTH'] = 'mth';
        $this->contents['LANG_DIFF_DAY'] = 'd';
        $this->contents['LANG_COMPETENCY_INFO'] = 'Add multiple competencies for employee eligibility for Courses and/or to set criteria for other complicated Tax requirement by the Government when you are doing Payroll for this employee. For e.g: NTS and PRC – higher-skilled, on MYE.';
        $this->contents['LANG_EMPLOYEE_SETUP'] = 'Employee Setup';
        $this->contents['LANG_EMPLOYEE_ID'] = 'Employee ID';
        $this->contents['LANG_ASSIGN_DEPARTMENT'] = 'Assign Department(s)';
        $this->contents['LANG_OFFICE_LOCATION'] = 'Office / Location';
        $this->contents['LANG_SELECT_OFFICE_LOCATION'] = 'Select Office / Location';
        $this->contents['LANG_ASSIGN_DESIGNATION'] = 'Assign Designation';
        $this->contents['LANG_ASSIGN_MANAGERS'] = 'Assign Manager(s)';
        $this->contents['LANG_ENTER_MANAGER_NAME'] = 'Enter Manager\'s Name';
        $this->contents['LANG_ASSIGN_ROLE'] = 'Assign Role(s)';
        $this->contents['LANG_SELECT_DESIGNATION'] = 'Select Designation';
        $this->contents['LANG_BASIC_SALARY'] = 'Basic Salary';
        $this->contents['LANG_SALARY_TYPE'] = 'Salary Type';
        $this->contents['LANG_SELECT_CONTRACT_TYPE'] = 'Select Contract Type';
        $this->contents['LANG_SELECT_PASS_TYPE'] = 'Select Pass Type';
        $this->contents['LANG_SELECT_ROLES'] = 'Select Role(s)';
        $this->contents['LANG_SELECT_DEPARTMENTS'] = 'Select Department(s)';
        $this->contents['LANG_YEAR'] = 'Year';
        $this->contents['LANG_MONTH'] = 'Month';
        $this->contents['LANG_DAY'] = 'Day';
        $this->contents['LANG_ADD_EMPLOYEE_COMPETENCIES'] = 'Add Employee Competencies';
        $this->contents['LANG_TYPE_ADD_NEW_COMPETENCY'] = 'Type and press Enter to add new competency';
        $this->contents['LANG_ENTER_SKILLSETS_KNOWLEDGE'] = 'Enter skillsets or knowledge';
        $this->contents['LANG_FOR_FOREIGNER'] = 'For Foreigner';
        $this->contents['LANG_WORK_PASS_TYPE'] = 'Work Pass Type';
        $this->contents['LANG_WORK_PASS_NUMBER'] = 'Work Pass Number';
        $this->contents['LANG_WORK_PASS_EXPIRY_DATE'] = 'Work Pass Expiry Date';
        $this->contents['LANG_HR_INFORMATION'] = 'HR Information';
        $this->contents['LANG_CONTACT'] = 'Contact';
        $this->contents['LANG_NAME'] = 'Name';
        $this->contents['LANG_EMPLOYMENT_STATUS'] = 'Employment Status';
        $this->contents['LANG_EMAIL'] = 'E-mail';
        $this->contents['LANG_MOBILE'] = 'Mobile';
        $this->contents['LANG_CONFIRM_SUSPEND_NAME'] = 'Are you sure you want to suspend {name}?';
        $this->contents['LANG_NO_LOGIN_HRS'] = 'This employee will no longer be able to login to the HRS System';
        $this->contents['LANG_CONFIRM_UNSUSPEND'] = 'Are you sure you want to unsuspend {name}?';
        $this->contents['LANG_ABLE_LOGIN_HRS'] = 'This employee will be able to login to the HRS System';
        $this->contents['LANG_CONFIRM_SUSPEND'] = 'Confirm Suspend';
        $this->contents['LANG_CONFIRM_UNSUSPEND'] = 'Confirm Unsuspend';
        $this->contents['LANG_PROVIDE_REASON'] = 'Provide reason(s) if any';
        $this->contents['LANG_UNSUSPEND_EMPLOYEE'] = 'Unsuspend Employee';
        $this->contents['LANG_SUSPENDED'] = 'Suspended';
        $this->contents['LANG_SUSPEND_EMPLOYEE'] = 'Suspend Employee';
        $this->contents['LANG_ACTIVE'] = 'Active';
        $this->contents['LANG_SUCCESSFULLY_SUSPENDED'] = '{name} has been successfully suspended!';
        $this->contents['LANG_SUCCESSFULLY_UNSUSPENDED'] = '{name} has been successfully unsuspended!';
        $this->contents['LANG_SET_RESIGNED_EMPLOYEE'] = 'Set {name} as Resigned Employee?';
        $this->contents['LANG_CONFIRM_RESIGN'] = 'Confirm Resign';
        $this->contents['LANG_SUCCESSFULLY_RESIGNED'] = '{name} has been successfully set to Resigned!';
        $this->contents['LANG_INACTIVE_SOON'] = 'Inactive Soon';
        $this->contents['LANG_EDIT_EMPLOYEE_INFO'] = 'Edit Employee Info';
        $this->contents['LANG_EMPLOYEE_RESIGNED'] = 'Employee Resigned';
        $this->contents['LANG_SEARCH_EMPLOYEE'] = 'Search Employee, Designation or Contract Type';

        $this->contents['LANG_ENTER_VALID_CHILD'] = 'Please enter valid child information';
        $this->contents['LANG_ENTER_VALID_EMAIL'] = 'Please enter valid email address';
        $this->contents['LANG_CONFIRM_DELETE_PHOTO'] = 'Are you sure you want to delete {name}\'s photo?';
        $this->contents['LANG_PHOTO_DELETED_UNDONE'] = 'Photo deleted will not be able to recover back';
        $this->contents['LANG_PHOTO_SUCCESSFULLY_DELETED'] = '{name}\'s photo has been successfully deleted!';
        $this->contents['LANG_EMPLOYEE_ADDED_SUCCESSFULLY'] = 'New Employee Added Successfully';
        $this->contents['LANG_ADD_ANOTHER_EMPLOYEE'] = 'Add Another Employee';
        $this->contents['LANG_GO_EMPLOYEE_LISTING'] = 'Go to Employee Listing';
        $this->contents['LANG_EMPLOYEE_UPDATED_SUCCESSFULLY'] = 'Employee Updated Successfully';
        $this->contents['LANG_CONTINUE_EDIT_EMPLOYEE'] = 'Continue Editing This Employee';
        $this->contents['LANG_PROFILE_UPDATED'] = 'Your Profile Has Been Updated Successfully';
    }
}
?>