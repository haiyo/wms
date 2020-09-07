<?php
namespace Markaxis\Leave;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: HolidayRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class HolidayRes extends Resource {


    // Properties


    /**
     * HolidayRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_EDIT_HOLIDAY'] = 'Edit Holiday';
        $this->contents['LANG_CREATE_CUSTOM_HOLIDAY'] = 'Create Custom Holiday';
        $this->contents['LANG_ENTER_HOLIDAY_TITLE'] = 'Please enter a Holiday Title';
        $this->contents['LANG_SELECT_DATE'] = 'Please select a date';
        $this->contents['LANG_HOLIDAY_CREATED_SUCCESSFULLY'] = 'Holiday Created Successfully';
        $this->contents['LANG_HOLIDAY_CREATED_SUCCESSFULLY_DESCRIPT'] = 'New Holiday has been successfully created';
        $this->contents['LANG_HOLIDAY_UPDATED_SUCCESSFULLY'] = 'Holiday Updated Successfully';
        $this->contents['LANG_HOLIDAY_UPDATED_SUCCESSFULLY_DESCRIPT'] = 'Holiday has been successfully updated';
        $this->contents['LANG_DELETE_HOLIDAY'] = 'Delete Holiday';
        $this->contents['LANG_SEARCH_HOLIDAY'] = 'Search Holiday';
        $this->contents['LANG_TITLE'] = 'Title';
        $this->contents['LANG_COUNTRY'] = 'Country';
        $this->contents['LANG_DATE'] = 'Date';
        $this->contents['LANG_WORK_DAY'] = 'Work Day';
        $this->contents['LANG_HOLIDAYS'] = 'Holidays';
        $this->contents['LANG_HOLIDAY_TITLE'] = 'Holiday Title';
        $this->contents['LANG_ENTER_HOLIDAY_TITLE'] = 'Enter a title for this holiday';
        $this->contents['LANG_IS_THIS_WORK_DAY'] = 'Is this a work day?';
    }
}
?>