<?php
namespace Markaxis\Payroll;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: TaxRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxRes extends Resource {


    // Properties


    /**
     * TaxRes Constructor
     * @return void
     */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_ENTER_RULE_TITLE'] = 'Please enter a Rule Title.';
        $this->contents['LANG_DEDUCTION_FROM_EMPLOYEE_SALARY'] = 'Deduction From Employee Salary';
        $this->contents['LANG_EMPLOYER_CONTRIBUTION'] = 'Employer Contribution';
        $this->contents['LANG_EMPLOYER_LEVY'] = 'Employer Levy';
        $this->contents['LANG_CRITERIA'] = 'Criteria';
    }
}
?>