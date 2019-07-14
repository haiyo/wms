<?php
namespace Markaxis\Company;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: CompanyRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CompanyRes extends Resource {


    // Properties


    /**
     * CompanyRes Constructor
     * @return void
     */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_COMPANY'] = 'Company';
        $this->contents['LANG_MY_COMPANY_BENEFITS'] = 'My Company Benefits';
        $this->contents['LANG_COMPANY_SETTINGS'] = 'Company Settings';
    }
}
?>