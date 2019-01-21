<?php
namespace Aurora\Config;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: UpgradeRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UpgradeRes extends Resource {


    // Properties


    /**
    * UpgradeRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_MENU_LINK_TITLE'] = 'Aurora Subscription Plan';
	}
}
?>