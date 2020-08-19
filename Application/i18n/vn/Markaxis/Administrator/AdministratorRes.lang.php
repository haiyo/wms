<?php
namespace Markaxis\Administrator;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: AdministratorRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AdministratorRes extends Resource {


    // Properties


    /**
     * AdministratorRes Constructor
     * @return void
     */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_ADMINISTRATOR'] = 'Người quản lý';
    }
}
?>