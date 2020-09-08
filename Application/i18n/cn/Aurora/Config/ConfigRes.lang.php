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
        $this->contents['LANG_CONFIGURATIONS'] = '系统配置';
        $this->contents['LANG_SAVED_NOTIFICATION'] = '配置设置已保存。';
        $this->contents['LANG_SAVE_CONFIG'] = '保存所有设置';
        $this->contents['LANG_POWERED_BY'] = 'Powered by';
        $this->contents['LANG_SECURE'] = '安全';
        $this->contents['LANG_NORMAL'] = '正常';
	}
}
?>