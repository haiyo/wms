<?php
namespace Markaxis\Employee;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ContractRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ContractRes extends Resource {


    // Properties


    /**
     * ContractRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_CONTRACT_TYPE'] = 'Contract Type';
        $this->contents['LANG_CREATE_NEW_CONTRACT_TYPE'] = 'Create New Contract Type';
        $this->contents['LANG_BULK_ACTION'] = 'Bulk Action';
        $this->contents['LANG_DESCRIPTION'] = 'Description';
        $this->contents['LANG_NO_OF_EMPLOYEE'] = 'No. of Employee';
        $this->contents['LANG_ACTIONS'] = 'Actions';
        $this->contents['LANG_CANCEL'] = 'Cancel';
        $this->contents['LANG_SUBMIT'] = 'Submit';
        $this->contents['LANG_DELETE_SELECTED_CONTRACTS'] = 'Delete Selected Contracts';
        $this->contents['LANG_CONTRACT_TITLE'] = 'Contract Title';
        $this->contents['LANG_ENTER_CONTRACT_TITLE'] = 'Enter Contract Title';
        $this->contents['LANG_ENTER_CONTRACT_DESCRIPTION'] = 'Enter Contract Description';
    }
}
?>