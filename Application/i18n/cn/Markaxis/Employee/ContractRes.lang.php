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
        $this->contents['LANG_DELETE_SELECTED_CONTRACTS'] = 'Delete Selected Contracts';
        $this->contents['LANG_CONTRACT_TITLE'] = 'Contract Title';
        $this->contents['LANG_ENTER_CONTRACT_TITLE'] = 'Enter Contract Title';
        $this->contents['LANG_ENTER_CONTRACT_DESCRIPTION'] = 'Enter Contract Description';
        $this->contents['LANG_EDIT_CONTRACT'] = 'Edit Contract';
        $this->contents['LANG_CREATE_NEW_CONTRACT'] = 'Create New Contract';
        $this->contents['LANG_PLEASE_ENTER_CONTRACT_TITLE'] = 'Please enter a Contract Title';
        $this->contents['LANG_CREATE_ANOTHER_CONTRACT'] = 'Create Another Contract';
        $this->contents['LANG_NO_CONTRACT_SELECTED'] = 'No Contract Selected';
        $this->contents['LANG_CONFIRM_DELETE_CONTRACT'] = 'Are you sure you want to delete the selected contracts?';
        $this->contents['LANG_EDIT_CONTRACT_TYPE'] = 'Edit Contract Type';
        $this->contents['LANG_DELETE_CONTRACT_TYPE'] = 'Delete Contract Type';
        $this->contents['LANG_SEARCH_CONTRACT_TYPE'] = 'Search Contract Type';
    }
}
?>