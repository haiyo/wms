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
        $this->contents = array( );
        $this->contents['LANG_EXPENSES_CLAIM'] = 'Expenses Claim';
        $this->contents['LANG_SUBMIT_NEW_CLAIM'] = 'Submit New Claim';
        $this->contents['LANG_CREATE_NEW_EXPENSE_TYPE'] = 'Create New Expense Type';
    }
}
?>