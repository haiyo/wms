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
        $this->contents['LANG_MENU_LINK_TITLE'] = '帐户政策设置';
        $this->contents['LANG_AUTO_TIMEOUT'] = '自动会话超时';
        $this->contents['LANG_AUTO_TIMEOUT_DESC'] = '选择空闲时间跨度以自动将用户注销到Aurora系统。 这也会影响管理员。';
        $this->contents['LANG_STRONG_PASSWORD'] = '实施强密码';
        $this->contents['LANG_STRONG_PASSWORD_DESC'] = '如果启用，则创建或更新用户帐户密码必须通过严格的条件才能被接受。 严格的密码标准必须包含至少1个大写字母，一个数字/符号和至少8个字符的长度.';

        $this->contents['LANG_ENABLE_FORGOT_PASSWORD'] = '启用忘记密码功能';
        $this->contents['LANG_ENABLE_FORGOT_PASSWORD_DESC'] = '允许忘记密码的用户通过电子邮件检索新密码。 如果禁用，则用户需要联系管理员以手动重置';

        $this->contents['LANG_PASSWORD_EXPIRY'] = '密码过期';
        $this->contents['LANG_PASSWORD_EXPIRY_DESC'] = '指定用户帐户密码过期的时间。 如果选中了“发送电子邮件提醒”，则会在指定时间的14天之前每3天通过电子邮件提醒用户一次，以在帐户被暂停之前更新新密码。';

        $this->contents['LANG_EXPIRY_PWD_MSG'] = '自定义密码到期消息';
        $this->contents['LANG_EXPIRY_PWD_MSG_DESC'] = '提供要发送给用户的自定义密码续订提醒消息。<strong>注意:</strong> 为了使其正常工作，将创建一个计划任务以每隔午夜12点执行发送电子邮件功能。 您可以按照此<a href="">准则</a>设置任务。';

        $this->contents['LANG_INACTIVE_EXPIRY'] = '用户帐户不活动到期';
        $this->contents['LANG_INACTIVE_EXPIRY_DESC'] = '指定一个时间段，以在指定的时间段后自动从所有记录中完全删除不活动的用户帐户。 如果选中了“发送电子邮件提醒”，则会在指定时间段的14天之前每3天通过电子邮件提醒用户登录系统，以防止其帐户被系统删除';

        $this->contents['LANG_INACTIVE_MSG'] = '自定义闲置到期消息';
        $this->contents['LANG_INACTIVE_MSG_DESC'] = '提供要发送给用户的自定义不活动提醒消息。 <strong>注意</strong>：为了使其正常工作，将创建一个计划任务，以在每午12点午夜执行发送电子邮件功能。 您可以按照此<a href="">准则</a>设置任务。';

        $this->contents['LANG_SEND_EMAIL'] = '发送电子邮件提醒';
	}
}
?>