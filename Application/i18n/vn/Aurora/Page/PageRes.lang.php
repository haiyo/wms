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
        $this->contents['LANG_HOME'] = 'Trang Chủ';
        $this->contents['LANG_EDIT_PROFILE'] = 'Chỉnh sửa hồ sơ';
        $this->contents['LANG_LOGOUT'] = 'Đăng xuất';
	}
}
?>