<?php
namespace Aurora\Admin;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: AdminRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AdminRes extends Resource {


    // Properties


    /**
     * AdminRes Constructor
     * @return void
     */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_ADMINISTRATIVE_CONTROL'] = 'Administrative Control';
        $this->contents['LANG_SYSTEM_CONFIGURATIONS'] = 'System Configurations';
    }
}
?>