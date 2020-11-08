<?php
namespace Aurora\User;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: UserRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserRes extends Resource {


    /**
    * UserRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        
        $this->contents = array( );
        $this->contents['LANG_FILTER_ROLE'] = '--- Filter by Role ---';
        $this->contents['LANG_ROLES_MANAGEMENT'] = 'Roles Management';
        $this->contents['LANG_USER_MANAGEMENT'] = 'User Management';
        $this->contents['LANG_CLOSE'] = 'Close';
        $this->contents['LANG_ADD_NEW'] = 'New Account';
        $this->contents['LANG_DELETE'] = 'Delete Account';
        $this->contents['LANG_ROLES'] = 'Have {n} roles';
        $this->contents['LANG_NO_ROLES'] = 'No role';
        $this->contents['LANG_PENDING'] = 'Pending';
        $this->contents['LANG_SUSPENDED'] = 'Suspended';
        $this->contents['LANG_ONLINE'] = 'Online';
        $this->contents['LANG_OFFLINE'] = 'Offline';
        $this->contents['LANG_AGE'] = 'age';
        $this->contents['LANG_TITLE'] = 'Account Name';
        $this->contents['LANG_USER_NOT_FOUND'] = 'User not found. Unable to retrieve record.';
        $this->contents['LANG_PASSWORD_NOT_MATCHED'] = 'Passwords do not matched. Please re-enter the passwords.';
        $this->contents['LANG_ENTER_REQUIRED_FIELDS'] = 'First name, last name and email are required to create an account.';
        $this->contents['LANG_INVALID_EMAIL'] = 'Invalid email address.';
        $this->contents['LANG_USERNAME_ALREADY_EXIST'] = 'The username already exist in record.';
        $this->contents['LANG_EMAIL_ALREADY_EXIST'] = 'The email already exist in record.';
        $this->contents['LANG_MUST_CHECK_USER'] = 'Click the checkbox to select one or more user accounts.';
        $this->contents['LANG_CONFIRM_DELETE'] = 'You have selected to delete {n} user account.|accounts. Deleting will remove all information connected to the account.\n\nIt is advisable to first suspend the account and verify all the information before deletion.\n\nThis action cannot be undone.';
        $this->contents['LANG_CONFIRM_DELETE_CURRENT'] = 'Are you sure you want to delete {name}\'s account? Deleting will remove all information connected to the account.\n\nIt is advisable to first suspend the account and verify all the information before deletion.\n\nThis action cannot be undone.';
        $this->contents['LANG_CONFIRM_REMOVE'] = 'Are you sure you want to remove {name}\'s photo?';
        $this->contents['LANG_NEW_ACCOUNT_CREATED'] = 'New account has been created.';
        $this->contents['LANG_GENERATE_PWD'] = 'There is no password being assign to this staff. Do you want the system to generate a random password and send it to the user?';
        $this->contents['LANG_CLICK_TO_UPLOAD'] = 'Click Here To Upload Photo';
        $this->contents['LANG_SEARCH_FOR_PEOPLE'] = 'Search for people';
        $this->contents['LANG_NO_RESULTS_FOUND'] = 'No results found';
        $this->contents['LANG_SEARCHING'] = 'Searching...';
        $this->contents['LANG_CHOOSE_ACTION'] = 'Choose an action to perform';
        $this->contents['LANG_MORE_ACTIONS'] = 'More actions';
        $this->contents['LANG_TOTAL_RECORDS'] = 'Total records';
        $this->contents['LANG_PAGE'] = 'Page';
        $this->contents['LANG_OF'] = 'of';
        $this->contents['LANG_SEARCH_BY_NAME'] = 'Search by name';
        $this->contents['LANG_IMPORT_EXPORT_CONTACTS'] = 'Import / Export Contacts';
        $this->contents['LANG_BIRTHDAY'] = 'Birthday';
        $this->contents['LANG_EMPLOYEE_SINCE'] = 'Employee since';
        // Form
        $this->contents['LANG_PERSONAL_INFORMATION'] = 'Personal Information';
        $this->contents['LANG_OTHER_INFORMATION'] = 'Other Information';
        $this->contents['LANG_SECURITY_ACCESS'] = 'Security Access';
        $this->contents['LANG_ADDITIONAL_NOTES'] = 'Additional Notes';
        $this->contents['LANG_REMOVE_PHOTO'] = 'Remove Photo';
        $this->contents['LANG_FIRST_NAME'] = 'First Name';
        $this->contents['LANG_LAST_NAME'] = 'Last Name / Surname';
        $this->contents['LANG_SSN'] = 'NRIC / FIN / Passport';
        $this->contents['LANG_ID_TYPE'] = 'ID Type';
        $this->contents['LANG_NATIONALITY'] = 'Nationality';
        $this->contents['LANG_PRIMARY_EMAIL'] = 'Primary Email Address';
        $this->contents['LANG_SECONDARY_EMAIL'] = 'Secondary Email Address';
        $this->contents['LANG_DATE_OF_BIRTH'] = 'Date Of Birth';
        $this->contents['LANG_PRIMARY_PHONE'] = 'Primary Phone';
        $this->contents['LANG_HOME_OFFICE_PHONE'] = 'Home / Office Phone';
        $this->contents['LANG_MOBILE_PHONE'] = 'Mobile Phone';
        $this->contents['LANG_ENTER_PHONE'] = 'Enter phone #';
        $this->contents['LANG_COUNTRY_BIRTH'] = 'Country of Birth';
        $this->contents['LANG_PRIMARY_ADDRESS'] = 'Primary Address';
        $this->contents['LANG_PREFERRED_LANGUAGE'] = 'Preferred Language';
        $this->contents['LANG_SELECT_LANGUAGE'] = 'Select Language';
        $this->contents['LANG_SECONDARY_ADDRESS'] = 'Secondary Address';
        $this->contents['LANG_GENDER'] = 'Gender';
        $this->contents['LANG_JOIN_DATE'] = 'Join Date';
        $this->contents['LANG_ACCOUNT_STATUS'] = 'Account Status';
        $this->contents['LANG_COMPANY'] = 'Company';
        $this->contents['LANG_JOB_TITLE'] = 'Job Title';
        $this->contents['LANG_STREET_ADDRESS'] = 'Street address';
        $this->contents['LANG_COUNTRY'] = 'Country';
        $this->contents['LANG_ZIP_CODE'] = 'ZIP / Postal code';
        $this->contents['LANG_STATE_PROVINCE'] = 'State / Province';
        $this->contents['LANG_CITY'] = 'City';
        $this->contents['LANG_SELECT_STATE'] = 'Select State';
        $this->contents['LANG_SELECT_CITY'] = 'Select City';
        $this->contents['LANG_RELIGION'] = 'Religion';
        $this->contents['LANG_RACE'] = 'Race';
        $this->contents['LANG_MARITAL_STATUS'] = 'Marital Status';
        $this->contents['LANG_HAVE_CHILDREN'] = 'Have Children(s)?';
        $this->contents['LANG_ENTER_CHILDREN_INFO'] = 'Enter Children(s) Information';
        $this->contents['LANG_CHILD_FULL_NAME'] = 'Child\'s Full Name';
        $this->contents['LANG_ADD_MORE_CHILDREN'] = 'Add More Children';
        $this->contents['LANG_ACCOUNT_LOGIN'] = 'Account Login';
        $this->contents['LANG_LOGIN_USERNAME'] = 'Login Username';
        $this->contents['LANG_LOGIN_PASSWORD'] = 'Login Password';
        $this->contents['LANG_AUTO_GENERATE'] = 'Auto Generate';
        $this->contents['LANG_CAPS_LOCK_ON'] = 'CAPS LOCK IS ON';
        $this->contents['LANG_PASSWORD'] = 'Password';
        $this->contents['LANG_EMAIL_RANDOM_PASSWORD'] = 'Email a random password';
        $this->contents['LANG_CONFIRMATION_PASSWORD'] = 'Confirmation Password';
        $this->contents['LANG_ASSIGN_ROLES'] = 'Assign Roles (max 5)';
        $this->contents['LANG_DEFAULT_ROLE'] = 'Default Role';
        $this->contents['LANG_NONE'] = 'None';
        $this->contents['LANG_NOTES'] = 'Notes';
        $this->contents['LANG_CANCEL'] = 'Cancel';
        $this->contents['LANG_SAVE'] = 'Save';
        $this->contents['LANG_YEAR'] = 'Year';
        $this->contents['LANG_MONTH'] = 'Month';
        $this->contents['LANG_DAY'] = 'Day';
        $this->contents['LANG_SELECT_COUNTRY'] = 'Select Country';
        $this->contents['LANG_SELECT_ID_TYPE'] = 'Select ID Type';
        $this->contents['LANG_SELECT_NATIONALITY'] = 'Select Nationality';
        $this->contents['LANG_SELECT_RACE'] = 'Select Race';
        $this->contents['LANG_SELECT_STATUS'] = 'Select Status';
        $this->contents['LANG_SELECT_RELIGION'] = 'Select Religion';


	}
}
?>