<?php
namespace Markaxis\Leave;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LeaveRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveRes extends Resource {


    // Properties


    /**
     * LeaveRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_LEAVE_EVENTS'] = 'Leave &amp; Events';
        $this->contents['LANG_TODAY'] = 'Today';
        $this->contents['LANG_TOMORROW'] = 'Tomorrow';
        $this->contents['LANG_WHOS_ON_LEAVE'] = 'Who\'s On Leave';
        $this->contents['LANG_NO_ONE_ON_LEAVE_TODAY'] = 'No one is on leave today.';
        $this->contents['LANG_NO_ONE_ON_LEAVE_TOMORROW'] = 'No one is on leave tomorrow.';
        $this->contents['LANG_ITS_HOLIDAY'] = 'It\'s Holiday!';
        $this->contents['LANG_LEAVE_BALANCE_STATUS'] = 'Leave Balance &amp; Status';
        $this->contents['LANG_LEAVE_BALANCE'] = 'Leave Balance';
        $this->contents['LANG_LEAVE_SETTINGS'] = 'Leave Settings';
        $this->contents['LANG_LEAVE_TYPE_SETTINGS'] = 'Leave Type Settings';
        $this->contents['LANG_CREATE_NEW_LEAVE_TYPE'] = 'Create New Leave Type';
        $this->contents['LANG_LEAVE_OVERVIEW'] = 'Leave Overview';
        $this->contents['LANG_APPLY_LEAVE_STATUS'] = 'Apply Leave / Status';
        $this->contents['LANG_PRO_RATED'] = 'Pro-Rated';
        $this->contents['LANG_NOT_PRO_RATED'] = 'Not Pro-Rated';
        $this->contents['LANG_ALLOW_HALF_DAY'] = 'Allow Half-day';
        $this->contents['LANG_NO_HALF_DAY'] = 'No Half-day';
        $this->contents['LANG_PAID_LEAVE'] = 'Paid Leave';
        $this->contents['LANG_UNPAID_LEAVE'] = 'UnPaid Leave';
        $this->contents['LANG_UPON_HIRED'] = 'Upon Hired';
        $this->contents['LANG_AFTER_PROBATION_PERIOD'] = 'After Probation Period';
        $this->contents['LANG_EMPLOYEE_CONFIRMATION_DATE'] = 'Employee Confirmation Date';
        $this->contents['LANG_FORFEITED'] = 'Is forfeited at the end of the period';
        $this->contents['LANG_CARRIED_OVER'] = 'Can be carried over to the next period';
        $this->contents['LANG_MONTHS'] = 'Months';
        $this->contents['LANG_WEEKS'] = 'Weeks';
        $this->contents['LANG_DAYS'] = 'Days';
        $this->contents['LANG_AVAILABLE'] = 'Available';
        $this->contents['LANG_OF'] = 'of';
        $this->contents['LANG_CONSUMED'] = 'Consumed';
        $this->contents['LANG_ENTITLED'] = 'Entitled';
        $this->contents['LANG_LEAVE_ACTIONS'] = 'Leave Actions';
        $this->contents['LANG_LEAVE_TYPE_CODE'] = 'Leave Type (Code)';
        $this->contents['LANG_PERIOD'] = 'Period';
        $this->contents['LANG_REASON'] = 'Reason';
        $this->contents['LANG_STATUS'] = 'Status';
        $this->contents['LANG_APPROVED_BY'] = 'Approved By';
        $this->contents['LANG_SELECT_LEAVE_TYPE'] = 'Select Leave Type';
        $this->contents['LANG_ENTITLEMENT'] = '% Of Entitlement';
        $this->contents['LANG_SELECT_PERIOD'] = 'Select Period';
        $this->contents['LANG_LEAVE_ENTITLEMENT'] = 'Leave Entitlement';
        $this->contents['LANG_LEAVE_TYPE_NAME'] = 'Leave Type Name';
        $this->contents['LANG_LEAVE_TYPE_PLACEHOLDER'] = 'Annual Leave, Sick Leave, Child Care Leave, etc';
        $this->contents['LANG_LEAVE_CODE'] = 'Leave Code';
        $this->contents['LANG_LEAVE_CODE_PLACEHOLDER'] = 'AL, SL, CCL, etc';
        $this->contents['LANG_LEAVE_CAN_BE_APPLIED'] = 'Leave Can Be Applied';
        $this->contents['LANG_PROBATION_PERIOD'] = 'Probation Period';
        $this->contents['LANG_MONTHLY_BASIS'] = 'Monthly Basis';
        $this->contents['LANG_IS_THIS_PRO_RATED'] = 'Is Pro-Rated?';
        $this->contents['LANG_IS_CHILD_CARE_LEAVE'] = 'Is Child Care Leave?';
        $this->contents['LANG_UNUSED_LIST'] = 'Unused Leave';
        $this->contents['LANG_CARRY_OVER_LIMIT'] = 'Carry Over Limit';
        $this->contents['LANG_TO_BE_USED_WITHIN'] = 'To Be Used Up Within';
        $this->contents['LANG_PAYROLL_PROCESS_AS'] = 'Payroll Process As';
        $this->contents['LANG_PAYROLL_FORMULA_FOR_UNPAID_LEAVE'] = 'Payroll Formula For UnPaid Leave';
        $this->contents['LANG_SHOW_CHART_LEAVE_BALANCE'] = 'Show Chart in Leave Balance';
        $this->contents['LANG_GENDER'] = 'Gender';
        $this->contents['LANG_DESIGNATION'] = 'Designation';
        $this->contents['LANG_CONTRACT_TYPE'] = 'Contract Type';
        $this->contents['LANG_COUNTRY'] = 'Country';
        $this->contents['LANG_NATIONALITY'] = 'Nationality';
        $this->contents['LANG_MARITAL_STATUS'] = 'Marital Status';
        $this->contents['LANG_MUST_HAVE_CHILDREN'] = 'Must Have Children';
        $this->contents['LANG_CHILD_BORN_IN'] = 'Child Born In';
        $this->contents['LANG_CHILD_NOT_BORN_IN'] = 'Child <strong><u>Not</u></strong> Born In';
        $this->contents['LANG_CHILD_MAX_AGE'] = 'Child Maximum Age';
        $this->contents['LANG_ENTITLEMENT_STRUCTURE'] = 'Entitlement Structure';
        $this->contents['LANG_LEAVE_STRUCTURE_HEADER'] = 'Define the leave entitlement structure based on Employee\'s number of completed months service.';
        $this->contents['LANG_SELECT_DESIGNATION_HEADER'] = 'Select the type of Designation(s) you want to assign to this Leave Group.';
        $this->contents['LANG_EMPLOYEE_START_MONTH'] = 'Employee Start Month';
        $this->contents['LANG_EMPLOYEE_END_MONTH'] = 'Employee End Month';
        $this->contents['LANG_ELIGIBLE_DAYS_LEAVES'] = 'Eligible Day(s) of Leaves';
        $this->contents['LANG_OFFICE_LOCATION'] = 'Office Location';
        $this->contents['LANG_FULL_DAY'] = 'Full Day';
        $this->contents['LANG_HALF_DAY'] = 'Half Day';
        $this->contents['LANG_INVALID_BALANCE'] = 'Invalid Leave Balance.';
        $this->contents['LANG_INVALID_DATE_RANGE'] = 'Please select a valid date range for your leave application.';
        $this->contents['LANG_APPLYING'] = 'You are applying {days} of leave (Excluding Weekends and Public Holidays).';
        $this->contents['LANG_APPLY_DAYS'] = '{n} day|days';
        $this->contents['LANG_APPLY_HOURS'] = '{n} hour|hours';
        $this->contents['LANG_HALF_DAY_NOT_ALLOWED'] = 'You cannot apply half day for this leave type.';
        $this->contents['LANG_CHOOSE_LEAVE_TYPE'] = 'Please choose a Leave Type.';
        $this->contents['LANG_INSUFFICIENT_LEAVE'] = 'You have insufficient leave for this request.';
        $this->contents['LANG_PENDING_ROW_GROUP'] = 'Leave Request';
        $this->contents['LANG_FROM'] = 'From';
        $this->contents['LANG_TO'] = 'To';
        $this->contents['LANG_ATTACHMENT'] = 'Attachment';
        $this->contents['LANG_NAME'] = 'Name';
        $this->contents['LANG_UNUSED_LEAVE'] = 'Unused Leave';
        $this->contents['LANG_LEAVE_TYPES'] = 'Leave Types';
        $this->contents['LANG_EDIT_LEAVE_TYPE'] = 'Edit Leave Type';
        $this->contents['LANG_DELETE_LEAVE_TYPE'] = 'Delete Leave Type';

        $this->contents['LANG_LEAVE_APPLIED_SUCCESSFULLY'] = 'Leave Applied Successfully';
        $this->contents['LANG_LEAVE_NOT_CONFIRM'] = 'Your leave application is not confirm yet and is subject to your manager(s) approval.';
        $this->contents['LANG_CANCEL_APPLIED_LEAVE'] = 'Cancel Applied Leave?';
        $this->contents['LANG_LEAVE_CANCELLED_SUCCESSFULLY'] = 'Leave Cancelled Successfully';
        $this->contents['LANG_CANCEL_APPLY'] = 'Cancel Apply';
        $this->contents['LANG_SEARCH_LEAVE_HISTORY'] = 'Search Leave History';
        $this->contents['LANG_SEARCH_LEAVE_TYPE'] = 'Search Leave Type';

        // Apply Form
        $this->contents['LANG_APPLY_LEAVE_NOW'] = 'Apply Leave Now';
        $this->contents['LANG_APPLY_LEAVE'] = 'Apply Leave';
        $this->contents['LANG_LEAVE_TYPE'] = 'Leave Type';
        $this->contents['LANG_REASON'] = 'Reason';
        $this->contents['LANG_PERSONAL_ISSUES_VACATION'] = 'For e.g: Personal issues, Vacation';
        $this->contents['LANG_START_DATE'] = 'Start Date';
        $this->contents['LANG_END_DATE'] = 'End Date';
        $this->contents['LANG_HALF_DAY_ON_FIRST_DAY'] = 'Half day on first day';
        $this->contents['LANG_HALF_DAY_ON_LAST_DAY'] = 'Half day on last day';
        $this->contents['LANG_APPROVING_MANAGERS'] = 'Approving Manager(s)';
        $this->contents['LANG_ENTER_MANAGER_NAME'] = 'Enter Manager\'s Name';

        $this->contents['LANG_HOLIDAYS'] = 'Holidays';
    }
}
?>