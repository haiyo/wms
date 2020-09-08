<?php
namespace Aurora\Page;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PageRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PageRes extends Resource {


    /**
    * PageRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        
        $this->contents = array( );
        $this->contents['LANG_HOME'] = '主页';
        $this->contents['LANG_EDIT_PROFILE'] = '编辑个人资料';
        $this->contents['LANG_LOGOUT'] = '登出';
	}
}
?>