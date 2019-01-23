<?php
namespace Aurora\Config;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: BrowserRes.lang.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class BrowserRes extends Resource {


    /**
    * BFLoginRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_MENU_LINK_TITLE'] = 'Browser Restrictions';
	}
}
?>