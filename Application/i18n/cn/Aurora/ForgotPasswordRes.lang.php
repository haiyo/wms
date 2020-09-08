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
        $this->contents['LANG_TOKEN_EXPIRED'] = '令牌已过期';
        $this->contents['LANG_PASSWORD_CANNOT_EMPTY'] = '密码不能为空';
        $this->contents['LANG_RESET_PASSWORD'] = '重设密码';
        $this->contents['LANG_RESET_PASSWORD_DESCRIPTION'] = '您的密码应该很难让别人猜到';
        $this->contents['LANG_NEW_PASSWORD'] = '新密码';
        $this->contents['LANG_RE_ENTER_PASSWORD'] = '重新输入密码';
        $this->contents['LANG_PLEASE_ENTER_PASSWORD'] = '请输入新密码';
        $this->contents['LANG_PLEASE_RE_ENTER_PASSWORD'] = '请输入密码';
        $this->contents['LANG_PASSWORD_MISMATCH'] = '密码不符合';
        $this->contents['LANG_PASSWORD_MISMATCH_DESCRIPTION'] = '您的密码和确认密码不匹配';
        $this->contents['LANG_ERROR'] = '错误';
        $this->contents['LANG_DONE'] = '完成!';
        $this->contents['LANG_SENT'] = '已发送!';
        $this->contents['LANG_GO_TO_LOGIN'] = '立即进入登录页面';
        $this->contents['LANG_LINK_SEND_TO'] = '重设密码的链接已发送至: ';
        $this->contents['LANG_RESET_PASSWORD_EMAIL'] = '有人要求重置您的Markaxis HRMS密码。 要重置密码，请使用以下链接:<br /><br />
                                                        ' . ROOT_URL . 'admin/forgotPassword/token/{TOKEN}<br /><br />
                                                        如果您未请求重设密码，请忽略此请求。';
	}
}
?>