<?php
namespace Aurora;
use \Resource;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: GlobalRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class GlobalRes extends Resource {


    // Properties


    /**
     * PayrollRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_NO'] = 'No';
        $this->contents['LANG_YES'] = 'Yes';
        $this->contents['LANG_BACK'] = 'Back';
        $this->contents['LANG_NEXT'] = 'Next';
        $this->contents['LANG_SHOW'] = 'Show';
        $this->contents['LANG_DONE'] = 'Done';
        $this->contents['LANG_CLOSE'] = 'Close';
        $this->contents['LANG_ERROR'] = 'Error';
        $this->contents['LANG_CONFIRM'] = 'Confirm';
        $this->contents['LANG_CANCEL'] = 'Cancel';
        $this->contents['LANG_CANCELLED'] = 'Cancelled';
        $this->contents['LANG_SUBMIT'] = 'Submit';
        $this->contents['LANG_ACTIONS'] = 'Actions';
        $this->contents['LANG_BROWSE'] = 'Browse';
        $this->contents['LANG_DELETE'] = 'Delete';
        $this->contents['LANG_TABLE_ENTRIES'] = 'Showing _START_ to _END_ of _TOTAL_ entries';
        $this->contents['LANG_COMPLETED'] = 'Completed';
        $this->contents['LANG_NO_FILE_SELECTED'] = 'No file selected';
        $this->contents['LANG_FILE_DELETED_UNDONE'] = 'File(s) deleted will not be able to recover back';
        $this->contents['LANG_BULK_ACTION'] = 'Bulk Action';
        $this->contents['LANG_CONFIRM_DELETE'] = 'Confirm Delete';
        $this->contents['LANG_CONFIRM_CANCEL'] = 'Confirm Cancel';
        $this->contents['LANG_DESCRIPTION'] = 'Description';
        $this->contents['LANG_PLEASE_HOLD_REFRESH'] = 'Please hold while the page is being refresh';
        $this->contents['LANG_PROVIDE_ALL_REQUIRED'] = 'Please provide all required fields';
        $this->contents['LANG_INVALID_DATE_RANGE'] = 'Invalid date range selected';
        $this->contents['LANG_CLOSE_WINDOW'] = 'Close Window';
        $this->contents['LANG_WHAT_TO_DO_NEXT'] = 'What do you want to do next?';
        $this->contents['LANG_PENDING_APPROVAL'] = 'Pending Approval';
        $this->contents['LANG_PENDING'] = 'Pending';
        $this->contents['LANG_APPROVED'] = 'Approved';
        $this->contents['LANG_UNAPPROVED'] = 'Unapproved';
        $this->contents['LANG_DISAPPROVED'] = 'Disapproved';
        $this->contents['LANG_NUMBER_ROWS'] = 'Number of Rows';
        $this->contents['LANG_PREV'] = 'Prev';
        $this->contents['LANG_FIRST'] = 'First';
        $this->contents['LANG_LAST'] = 'Last';
        $this->contents['LANG_NO_OF_EMPLOYEE'] = 'No. of Employee';
        $this->contents['LANG_UPLOAD_SUPPORTING_DOCUMENT'] = 'Upload Supporting Document (If any)';
        $this->contents['LANG_ACCEPTED_FORMATS'] = 'Accepted formats: pdf, doc. Max file size';
        $this->contents['LANG_APPROVING_MANAGERS'] = 'Approving Manager(s)';
        $this->contents['LANG_ENTER_MANAGER_NAME'] = 'Enter Manager\'s Name';

        $this->contents['LANG_SUCCESSFULLY_CREATED'] = '{title} has been successfully created!';
        $this->contents['LANG_ARE_YOU_SURE_DELETE'] = 'Are you sure you want to delete {title}?';
        $this->contents['LANG_SUCCESSFULLY_DELETE'] = '{title} has been successfully deleted!';
        $this->contents['LANG_ITEMS_SUCCESSFULLY_DELETED'] = '{count} items has been successfully deleted!';
        $this->contents['LANG_CANNOT_UNDONE_DELETED'] = 'This action cannot be undone once deleted';

    }
}
?>