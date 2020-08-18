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
        $this->contents['LANG_MAX_AMOUNT'] = 'Maximum amount claimable: {maxAmount}';
        $this->contents['LANG_AMOUNT_OVER_MAX'] = 'Your claim amount is over the maximum limit of {maxAmount}.';
        $this->contents['LANG_CLAIM_PENDING_APPROVAL'] = '<?TPLVAR_FNAME?> <?TPLVAR_LNAME?>\'s claim request
                                                          is pending your approval.';
    }
}
?>