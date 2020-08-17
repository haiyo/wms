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
    }
}
?>