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
        $this->contents['LANG_FOUND_ISSUE'] = 'Tìm thấy sự cố?';
        $this->contents['LANG_TELL_US_WHATS_WRONG'] = 'Hãy cho chúng tôi biết điều gì đã sai';
        $this->contents['LANG_SUBJECT'] = 'Môn học';
        $this->contents['LANG_ENTER_SUBJECT'] = 'Chủ đề của vấn đề';
        $this->contents['LANG_DESCRIPTION'] = 'Sự miêu tả';
        $this->contents['LANG_ENTER_DESCRIPTION'] = 'Mô tả những gì đã xảy ra và các bước để tái tạo sự cố';
        $this->contents['LANG_UPLOAD_SCREENSHOT'] = 'Tải lên ảnh chụp màn hình';
	}
}
?>