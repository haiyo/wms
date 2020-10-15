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
        $this->contents['LANG_INVALID_COUNTRY'] = 'Invalid Country';
        $this->contents['LANG_PENDING_ROW_GROUP'] = 'Claim Request';
        $this->contents['LANG_MAX_AMOUNT_CLAIMABLE'] = 'Maximum amount claimable: {maxAmount}';
        $this->contents['LANG_AMOUNT_OVER_MAX'] = 'Your claim amount is over the maximum limit of {maxAmount}.';
        $this->contents['LANG_CLAIM_PENDING_APPROVAL'] = '<?TPLVAR_FNAME?> <?TPLVAR_LNAME?>\'s claim request is pending your approval.';

        $this->contents['LANG_CLAIM_TYPE'] = 'Claim Type';
        $this->contents['LANG_AMOUNT'] = 'Amount';
        $this->contents['LANG_ATTACHMENT'] = 'Attachment';
        $this->contents['LANG_STATUS'] = 'Status';
        $this->contents['LANG_MANAGERS'] = 'Manager(s)';
        $this->contents['LANG_DATE_CREATED'] = 'Date Created';
        $this->contents['LANG_SELECT_EXPENSE_ITEM'] = 'Select Expense Item';
        $this->contents['LANG_ENTER_DESCRIPTION_CLAIM'] = 'Enter description for this claim';
        $this->contents['LANG_AMOUNT_TO_CLAIM'] = 'Amount To Claim';
        $this->contents['LANG_ENTER_CLAIM_AMOUNT'] = 'Enter claim amount';

        $this->contents['LANG_EXPENSE_ITEM_TITLE'] = 'Expense Item Title';
        $this->contents['LANG_COUNTRY'] = 'Country';
        $this->contents['LANG_MAX_AMOUT'] = 'Max Amount';
        $this->contents['LANG_EXPENSE_TYPE'] = 'Expense Type';
        $this->contents['LANG_APPLY_COUNTRY'] = 'Apply To Which Country';
        $this->contents['LANG_SELECT_COUNTRY'] = 'Select Country';
        $this->contents['LANG_ENTER_TITLE_EXPENSE_TYPE'] = 'Enter a title for this expense type';
        $this->contents['LANG_MAX_ALLOWED_CLAIM'] = 'Maximum Amount Allowed For Claim';
        $this->contents['LANG_ENTER_AMOUNT'] = 'Enter an amount (Enter 0 for unlimited)';
        $this->contents['LANG_EDIT_CLAIM'] = 'Edit Claim';
        $this->contents['LANG_CREATE_NEW_CLAIM'] = 'Create New Claim';
        $this->contents['LANG_CONFIRM_CANCEL_CLAIM'] = 'Are you sure you want to cancel the claim {title}?';
        $this->contents['LANG_CONFIRM_CANCEL_CLAIM_DESCRIPT'] = 'This action cannot be undone once cancelled';
        $this->contents['LANG_CLAIM_CANCELLED_SUCCESSFULLY'] = '{title} has been successfully cancelled!';
        $this->contents['LANG_CLAIM_SUCCESSFULLY_CREATED'] = 'Claim has been successfully created!';
        $this->contents['LANG_CREATE_ANOTHER_CLAIM'] = 'Create Another Claim';
        $this->contents['LANG_PAID'] = 'Paid';
        $this->contents['LANG_CANCEL_CLAIM'] = 'Cancel Claim';
        $this->contents['LANG_SEARCH_CLAIM'] = 'Search Claim';

        $this->contents['LANG_EDIT_EXPENSE_TYPE'] = 'Edit Expense Type';
        $this->contents['LANG_ENTER_EXPENSE_TYPE'] = 'Please enter a Expense Type Title';
        $this->contents['LANG_ENTER_MAX_AMOUNT'] = 'Please enter a maximum amount';
        $this->contents['LANG_PLEASE_SELECT_COUNTRY'] = 'Please select country';
        $this->contents['LANG_EXPENSE_CREATED_SUCCESSFULLY'] = 'Expense Type Created Successfully';
        $this->contents['LANG_EXPENSE_CREATED_SUCCESSFULLY_DESCRIPT'] = 'New expense type has been successfully created';
        $this->contents['LANG_EXPENSE_UPDATED_SUCCESSFULLY'] = 'Expense Type Updated Successfully';
        $this->contents['LANG_EXPENSE_UPDATED_SUCCESSFULLY_DESCRIPT'] = 'Expense type has been successfully updated';
        $this->contents['LANG_EDIT_EXPENSE_ITEM'] = 'Edit Expense Item';
        $this->contents['LANG_DELETE_EXPENSE_ITEM'] = 'Delete Expense Item';
        $this->contents['LANG_SEARCH_EXPENSE_TYPE'] = 'Search Expense Type';
    }
}
?>