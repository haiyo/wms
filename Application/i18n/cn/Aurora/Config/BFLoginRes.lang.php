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
        $this->contents['LANG_MENU_LINK_TITLE'] = '蛮力登录保护';
        $this->contents['LANG_ENABLE_BF'] = '启用蛮力登录防护';
        $this->contents['LANG_ENABLE_BF_DESC'] = '防止未经授权的用户使用字典或手动猜测密码来尝试登录系统。';
        $this->contents['LANG_BF_NUM_OF_FAILED'] = '尝试登录失败的次数';
        $this->contents['LANG_BF_NUM_OF_FAILED_DESC'] = '选择尝试采取登录操作之前尝试登录的次数。';
        $this->contents['LANG_ENFORCE_ACTION'] = '加强行动';
        $this->contents['LANG_ENFORCE_ACTION_DESC'] = '选择在失败的登录尝试允许的次数用完之后，Aurora应该执行的操作类型。';
        $this->contents['LANG_BF_TIPS'] = '<strong>提示:</strong> 为了进一步增强此安全功能，建议启用<strong>使用策略设置</strong>中的“强制强密码”设置。';
        $this->contents['LANG_NO_ACTION'] = '没有行动';
        $this->contents['LANG_BLOCK_IP_FOR_N'] = '封锁IP位址{n}分钟';
        $this->contents['LANG_NEVER'] = '决不';
        $this->contents['LANG_ONLY_EXHAUSTED'] = '只有失败失败了';
        $this->contents['LANG_ALWAYS'] = '一律包括';
        $this->contents['LANG_SEND_EMAIL'] = '发送电子邮件警报';
        $this->contents['LANG_SEND_EMAIL_DESC'] = '尝试登录失败时向网站管理员发送电子邮件警报。';

        $this->contents['LANG_ALERT_SUBJECT'] = '蛮力警报';
        $this->contents['LANG_ALERT_MSG'] = '{ip_address}已超出{num_failed}个登录的最大数量，并已被阻止{bf_action}分钟。';
	}
}
?>