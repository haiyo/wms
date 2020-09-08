<?php
namespace Markaxis\Company;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: OfficeRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class OfficeRes extends Resource {


    // Properties


    /**
     * OfficeRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_OFFICE'] = 'Office';
        $this->contents['LANG_CREATE_NEW_OFFICE'] = 'Create New office';
        $this->contents['LANG_OFFICE_NAME'] = 'Office Name';
        $this->contents['LANG_ADDRESS'] = 'Address';
        $this->contents['LANG_COUNTRY'] = 'Country';
        $this->contents['LANG_WORK_DAYS'] = 'Work Days';
        $this->contents['LANG_TOTAL_EMPLOYEE'] = 'Total Employee';
        $this->contents['LANG_ENTER_OFFICE_NAME'] = 'Enter Office Name';
        $this->contents['LANG_OFFICE_ADDRESS'] = 'Office Address';
        $this->contents['LANG_ENTER_OFFICE_ADDRESS'] = 'Enter Office Address';
        $this->contents['LANG_OFFICE_COUNTRY'] = 'Office Country';
        $this->contents['LANG_OFFICE_TYPE'] = 'Office Type';
        $this->contents['LANG_WORKING_DAY_FROM'] = 'Working Day From';
        $this->contents['LANG_WORKING_DAY_TO'] = 'Working Day To';
        $this->contents['LANG_LAST_DAY_IS_HALF_DAY'] = 'Last day is half day';
        $this->contents['LANG_SELECT_COUNTRY'] = 'Select Country';
        $this->contents['LANG_SELECT_OFFICE_TYPE'] = 'Select Office Type';
        $this->contents['LANG_SELECT_WORK_DAY_TO'] = 'Select Work Day To';
        $this->contents['LANG_SELECT_WORK_DAY_FROM'] = 'Select Work Day From';
        $this->contents['LANG_ENTER_REQUIRED_FIELDS'] = 'Please enter all required fields.';
        $this->contents['LANG_MUST_AT_LEAST_ONE_MAIN'] = 'There must be at least 1 main office.';
        $this->contents['LANG_EDIT_OFFICE'] = 'Edit Office';
        $this->contents['LANG_PLEASE_ENTER_OFFICE_NAME'] = 'Please enter a Office Name';
        $this->contents['LANG_PLEASE_SELECT_COUNTRY'] = 'Please select country of operation';
        $this->contents['LANG_CREATE_ANOTHER_OFFICE'] = 'Create Another Office';
        $this->contents['LANG_MAIN'] = 'Main';
        $this->contents['LANG_DELETE_OFFICE'] = 'Delete Office';
        $this->contents['LANG_SEARCH_OFFICE'] = 'Search Office';
    }
}
?>