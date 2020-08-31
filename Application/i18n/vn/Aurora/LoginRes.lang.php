<?php
namespace Aurora;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LoginRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LoginRes extends Resource {

    
    /**
    * LoginRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_LANGUAGE'] = 'Ngôn ngữ';
        $this->contents['LANG_LOGIN_TITLE'] = 'Đăng nhập vào {WEBSITE_NAME}';
        $this->contents['LANG_LOGIN_DESCRIPT'] = 'Bạn cần ủy quyền để truy cập khu vực này';
        $this->contents['LANG_EMAIL_ADDRESS'] = 'Địa chỉ email';
        $this->contents['LANG_SIGN_IN'] = 'Đăng nhập';
        $this->contents['LANG_FORGOT_PASSWORD'] = 'Quên mật khẩu?';
        $this->contents['LANG_PASSWORD'] = 'Mật khẩu';
        $this->contents['LANG_ENTER_VALID_EMAIL'] = 'Vui lòng nhập một địa chỉ email hợp lệ';
        $this->contents['LANG_ENTER_VALID_USERNAME'] = 'Vui lòng nhập tên người dùng hợp lệ';
        $this->contents['LANG_ENTER_PASSWORD'] = 'Xin hãy điền mật khẩu';
        $this->contents['LANG_ENTER_ALL_FIELDS'] = 'Vui lòng nhập tất cả các trường';
        $this->contents['LANG_PLEASE_ENTER_EMAIL'] = 'Vui lòng nhập địa chỉ email';
        $this->contents['LANG_LOGIN_ERROR'] = 'Đăng nhập không hợp lệ';
        $this->contents['LANG_INVALID_LOGIN'] = 'Tên người dùng hoặc kết hợp mật khẩu không chính xác. Mật khẩu phân biệt chữ hoa chữ thường. Vui lòng kiểm tra khóa CAPS của bạn.';
        $this->contents['LANG_OOPS'] = 'Oops...';
        $this->contents['LANG_SERVICE_UNAVAILABLE'] = 'Dịch vụ đăng nhập hiện không khả dụng. Bạn có thể đã vượt quá số lần đăng nhập tối đa. Vui lòng thử lại sau';
	}
}
?>