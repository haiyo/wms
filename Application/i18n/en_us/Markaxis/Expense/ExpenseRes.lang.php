<?php
namespace Markaxis\Expense;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ExpenseRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ExpenseRes extends Resource {


    // Properties


    /**
     * ExpenseRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_EXPENSES_CLAIM'] = 'Expenses Claim';
        $this->contents['LANG_CREATE_NEW_CLAIM'] = 'Create New Claim';
        $this->contents['LANG_CREATE_NEW_EXPENSE_TYPE'] = 'Create New Expense Type';
        $this->contents['LANG_INVALID_CLAIM_TYPE'] = 'Invalid Claim Type';
        $this->contents['LANG_INVALID_CURRENCY'] = 'Invalid Currency';
        $this->contents['LANG_PENDING_ROW_GROUP'] = 'Claim Request';
        $this->contents['LANG_APPROVED'] = 'Approved';
        $this->contents['LANG_UNAPPROVED'] = 'Unapproved';
        $this->contents['LANG_PENDING'] = 'Pending';
        $this->contents['LANG_MAX_AMOUNT_CLAIMABLE'] = 'Maximum amount claimable: {maxAmount}';
        $this->contents['LANG_AMOUNT_OVER_MAX'] = 'Your claim amount is over the maximum limit of {maxAmount}.';
        $this->contents['LANG_CLAIM_PENDING_APPROVAL'] = '<?TPLVAR_FNAME?> <?TPLVAR_LNAME?>\'s claim request
                                                          is pending your approval.';

        $this->contents['LANG_CLAIM_TYPE'] = 'Claim Type';
        $this->contents['LANG_DESCRIPTION'] = 'Description';
        $this->contents['LANG_AMOUNT'] = 'Amount';
        $this->contents['LANG_ATTACHMENT'] = 'Attachment';
        $this->contents['LANG_STATUS'] = 'Status';
        $this->contents['LANG_MANAGERS'] = 'Manager(s)';
        $this->contents['LANG_DATE_CREATED'] = 'Date Created';
        $this->contents['LANG_ACTIONS'] = 'Actions';
        $this->contents['LANG_SELECT_EXPENSE_TYPE'] = 'Select Expense Type';
        $this->contents['LANG_ENTER_DESCRIPTION_CLAIM'] = 'Enter description for this claim';
        $this->contents['LANG_AMOUNT_TO_CLAIM'] = 'Amount To Claim';
        $this->contents['LANG_ENTER_CLAIM_AMOUNT'] = 'Enter claim amount';
        $this->contents['LANG_UPLOAD_SUPPORTING_DOCUMENT'] = 'Upload Supporting Document (If any)';
        $this->contents['LANG_ACCEPTED_FORMATS'] = 'Accepted formats: pdf, doc. Max file size';
        $this->contents['LANG_APPROVING_MANAGERS'] = 'Approving Manager(s)';
        $this->contents['LANG_ENTER_MANAGER_NAME'] = 'Enter Manager\'s Name';
        $this->contents['LANG_CANCEL'] = 'Cancel';
        $this->contents['LANG_SUBMIT'] = 'Submit';
        $this->contents['LANG_EXPENSE_ITEM_TITLE'] = 'Expense Item Title';
        $this->contents['LANG_MAX_AMOUT'] = 'Max Amount';
        $this->contents['LANG_ACTIONS'] = 'Actions';
        $this->contents['LANG_EXPENSE_TYPE'] = 'Expense Type';
        $this->contents['LANG_ENTER_EXPENSE_TYPE'] = 'Enter a title for this expense type';
        $this->contents['LANG_MAX_ALLOWED_CLAIM'] = 'Maximum Amount Allowed For Claim';
        $this->contents['LANG_ENTER_AMOUNT'] = 'Enter an amount (Enter 0 for unlimited)';
    }
}
?>