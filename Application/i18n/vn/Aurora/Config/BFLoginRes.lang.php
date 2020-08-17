<?php
namespace Aurora\Config;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
  * @since Monday, July  30, 2012
 * @version $Id: BFLoginRes.lang.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class BFLoginRes extends Resource {


    /**
    * BFLoginRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_MENU_LINK_TITLE'] = 'Bảo vệ đăng nhập Brute Force';
        $this->contents['LANG_ENABLE_BF'] = 'Bật lá chắn đăng nhập Brute Force';
        $this->contents['LANG_ENABLE_BF_DESC'] = 'Ngăn người dùng trái phép sử dụng từ điển hoặc đoán mật khẩu theo cách thủ công để cố gắng đăng nhập vào hệ thống.';
        $this->contents['LANG_BF_NUM_OF_FAILED'] = 'Số lần đăng nhập không thành công';
        $this->contents['LANG_BF_NUM_OF_FAILED_DESC'] = 'Chọn số lần thử đăng nhập trước khi thực hiện bất kỳ hành động nào.';
        $this->contents['LANG_ENFORCE_ACTION'] = 'Thực thi hành động';
        $this->contents['LANG_ENFORCE_ACTION_DESC'] = 'Chọn loại hành động mà Aurora sẽ thực hiện sau khi hết số lần cho phép đăng nhập không thành công.';
        $this->contents['LANG_BF_TIPS'] = '<strong>Tips:</strong> To strengthen this security feature even further, it is recommended to enable the "Enforce Strong Password" setting located in the <strong>Usage Policy Settings</strong>.';
        $this->contents['LANG_NO_ACTION'] = 'Không có hành động';
        $this->contents['LANG_BLOCK_IP_FOR_N'] = 'Chặn địa chỉ IP trong {n} phút';
        $this->contents['LANG_NEVER'] = 'Không bao giờ';
        $this->contents['LANG_ONLY_EXHAUSTED'] = 'Only when fail exhausted';
        $this->contents['LANG_ALWAYS'] = 'Always include';
        $this->contents['LANG_SEND_EMAIL'] = 'Send Email Alert';
        $this->contents['LANG_SEND_EMAIL_DESC'] = 'Send an email alert to Webmaster on failed login attempt.';

        $this->contents['LANG_ALERT_SUBJECT'] = 'Brute Force Alert';
        $this->contents['LANG_ALERT_MSG'] = '{ip_address} has exceeded the maximum number of {num_failed} login and have been blocked for {bf_action} minutes.';
	}
}
?>