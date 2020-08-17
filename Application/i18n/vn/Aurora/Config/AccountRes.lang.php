<?php
namespace Aurora\Config;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: AccountRes.lang.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AccountRes extends Resource {


    /**
    * AccountRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_MENU_LINK_TITLE'] = 'Cài đặt chính sách tài khoản';
        $this->contents['LANG_AUTO_TIMEOUT'] = 'Thời gian chờ phiên tự động';
        $this->contents['LANG_AUTO_TIMEOUT_DESC'] = 'Chọn khoảng thời gian không hoạt động để tự động đăng xuất người dùng khỏi Hệ thống Aurora. Điều này cũng sẽ ảnh hưởng đến Quản trị viên.';
        $this->contents['LANG_STRONG_PASSWORD'] = 'Thực thi mật khẩu mạnh';
        $this->contents['LANG_STRONG_PASSWORD_DESC'] = 'Nếu được bật, việc tạo hoặc cập nhật mật khẩu tài khoản của người dùng phải vượt qua các tiêu chí nghiêm ngặt để được chấp nhận. Tiêu 
        chí mật khẩu mạnh phải bao gồm ít nhất 1 chữ cái in hoa, một số / ký hiệu và độ dài tối thiểu là 8 ký tự.';

        $this->contents['LANG_ENABLE_FORGOT_PASSWORD'] = 'Bật tính năng Quên mật khẩu';
        $this->contents['LANG_ENABLE_FORGOT_PASSWORD_DESC'] = 'Cho phép người dùng đã quên mật khẩu của họ lấy lại mật khẩu mới qua email.
         Nếu bị vô hiệu hóa, người dùng sẽ cần liên hệ với Quản trị viên để đặt lại theo cách thủ công.';

        $this->contents['LANG_PASSWORD_EXPIRY'] = 'Mật khẩu hết hạn';
        $this->contents['LANG_PASSWORD_EXPIRY_DESC'] = 'Chỉ định khoảng thời gian để mật khẩu tài khoản người dùng hết hạn. 
        Nếu "Gửi lời nhắc qua email" được chọn, người dùng sẽ được nhắc qua email 3 ngày một lần trước 14 ngày kể từ thời gian quy định để cập nhật mật khẩu mới trước khi tài khoản của họ bị tạm ngưng.';

        $this->contents['LANG_EXPIRY_PWD_MSG'] = 'Thông báo hết hạn mật khẩu tùy chỉnh';
        $this->contents['LANG_EXPIRY_PWD_MSG_DESC'] = 'Provide a custom password renewel reminder message to be send to the user.
                      <strong>Note:</strong> In order for this to work, a schedule task will be created to perform the
                      send email function every 12am midnight. You may follow this <a href="">guidelines</a> to setting
                      up the task.';

        $this->contents['LANG_INACTIVE_EXPIRY'] = 'Tài khoản Người dùng Không hoạt động Hết hạn';
        $this->contents['LANG_INACTIVE_EXPIRY_DESC'] = 'Chỉ định khoảng thời gian để tự động xóa hoàn toàn các tài khoản người dùng không hoạt động khỏi tất cả các bản ghi sau khoảng thời gian được chỉ định.
         Nếu "Gửi lời nhắc qua email" được chọn, người dùng sẽ được nhắc qua email 3 ngày một lần trước 14 ngày của khoảng thời gian quy định để đăng nhập vào hệ thống để tránh việc tài khoản của họ bị hệ thống xóa.';

        $this->contents['LANG_INACTIVE_MSG'] = 'Thông báo hết hạn không hoạt động tùy chỉnh';
        $this->contents['LANG_INACTIVE_MSG_DESC'] = 'Provide a custom inactivity reminder message to be send to the user.
              <strong>Note:</strong> In order for this to work, a schedule task will be created to perform the
              send email function every 12am midnight. You may follow this <a href="">guidelines</a> to setting
              up the task.';

        $this->contents['LANG_SEND_EMAIL'] = 'Gửi lời nhắc qua email';
	}
}
?>