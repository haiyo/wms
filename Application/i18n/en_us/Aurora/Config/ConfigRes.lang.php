<?php
namespace Aurora\Config;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ConfigRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ConfigRes extends Resource {


    // Properties


    /**
    * ConfigRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_CONFIGURATIONS'] = 'System Configurations';
        $this->contents['LANG_SAVED_NOTIFICATION'] = 'Configuration settings has been saved.';
        $this->contents['LANG_SAVE_CONFIG'] = 'Save All Settings';
        $this->contents['LANG_POWERED_BY'] = 'Powered by';
        $this->contents['LANG_SECURE'] = 'Secure';
        $this->contents['LANG_NORMAL'] = 'Normal';
	}
}
?>