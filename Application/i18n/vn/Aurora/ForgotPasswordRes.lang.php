<?php
namespace Aurora;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ForgotPasswordRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ForgotPasswordRes extends Resource {

    
    /**
    * ForgotPasswordRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_TOKEN_EXPIRED'] = 'Mã thông báo đã hết hạn';
        $this->contents['LANG_PASSWORD_CANNOT_EMPTY'] = 'Mật khẩu không được để trống';
        $this->contents['LANG_RESET_PASSWORD'] = 'Đặt lại mật khẩu';
        $this->contents['LANG_RESET_PASSWORD_DESCRIPTION'] = 'Mật khẩu của bạn phải khó để người khác đoán được';
        $this->contents['LANG_NEW_PASSWORD'] = 'Mật khẩu mới';
        $this->contents['LANG_RE_ENTER_PASSWORD'] = 'Nhập lại mật khẩu';
        $this->contents['LANG_PLEASE_ENTER_PASSWORD'] = 'Vui lòng nhập mật khẩu mới';
        $this->contents['LANG_PLEASE_RE_ENTER_PASSWORD'] = 'Vui lòng nhập mật khẩu';
        $this->contents['LANG_PASSWORD_MISMATCH'] = 'Mật khẩu không khớp';
        $this->contents['LANG_PASSWORD_MISMATCH_DESCRIPTION'] = 'Mật khẩu của bạn và mật khẩu xác nhận không khớp';
        $this->contents['LANG_ERROR'] = 'lỗi';
        $this->contents['LANG_DONE'] = 'Làm xong!';
        $this->contents['LANG_SENT'] = 'Gởi!';
        $this->contents['LANG_GO_TO_LOGIN'] = 'Tới trang Đăng nhập ngay bây giờ';
        $this->contents['LANG_LINK_SEND_TO'] = 'Một liên kết để đặt lại mật khẩu của bạn đã được gửi đến: ';
        $this->contents['LANG_RESET_PASSWORD_EMAIL'] = 'Đã có yêu cầu đặt lại mật khẩu của bạn cho HRMSCloud. Để đặt lại mật khẩu của bạn, hãy sử dụng liên kết này:<br /><br />
                                                        ' . ROOT_URL . 'admin/forgotPassword/token/{TOKEN}<br /><br />
                                                        Nếu bạn không yêu cầu đặt lại mật khẩu của mình, vui lòng bỏ qua yêu cầu này';
	}
}
?>