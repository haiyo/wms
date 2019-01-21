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
        $this->contents['LANG_MENU_LINK_TITLE'] = 'Account Policy Settings';
        $this->contents['LANG_AUTO_TIMEOUT'] = 'Auto Session Timeout';
        $this->contents['LANG_AUTO_TIMEOUT_DESC'] = 'Select a time span on idle to automatically log user out of the Aurora System. This will affect the Administrator as well.';
        $this->contents['LANG_STRONG_PASSWORD'] = 'Enforce Strong Password';
        $this->contents['LANG_STRONG_PASSWORD_DESC'] = 'If enabled, creation or updating of user\'s account password must pass
                      strict criteria in order to be accepted. Strong password criteria must consist at least 1 capital letter,
                      a number/symbol and a minimum length of 8 characters.';

        $this->contents['LANG_ENABLE_FORGOT_PASSWORD'] = 'Enable Forgot Password Feature';
        $this->contents['LANG_ENABLE_FORGOT_PASSWORD_DESC'] = 'Allow user who had forgotten their password to retrieve a new password
                      through email. If disabled, user will need to contact the Administrator to reset manually.';

        $this->contents['LANG_PASSWORD_EXPIRY'] = 'Password Expiry';
        $this->contents['LANG_PASSWORD_EXPIRY_DESC'] = 'Specify the period of time to expire user account password. If "Send Email Reminder"
                      is checked, user will be reminded via email every 3 days before 14 days of the specified time to
                      update a new password before their account is suspended.';

        $this->contents['LANG_EXPIRY_PWD_MSG'] = 'Custom Password Expiry Message';
        $this->contents['LANG_EXPIRY_PWD_MSG_DESC'] = 'Provide a custom password renewel reminder message to be send to the user.
                      <strong>Note:</strong> In order for this to work, a schedule task will be created to perform the
                      send email function every 12am midnight. You may follow this <a href="">guidelines</a> to setting
                      up the task.';

        $this->contents['LANG_INACTIVE_EXPIRY'] = 'User Account Inactivity Expiry';
        $this->contents['LANG_INACTIVE_EXPIRY_DESC'] = 'Specify a period of time to automatically remove inactive user
              accounts completely from all records after the specified period of time. If "Send Email Reminder" is checked,
              user will be reminded via email every 3 days before 14 days of the specified period of time to login to the
              system to prevent their account from being removed by the system.';

        $this->contents['LANG_INACTIVE_MSG'] = 'Custom Inactivity Expiry Message';
        $this->contents['LANG_INACTIVE_MSG_DESC'] = 'Provide a custom inactivity reminder message to be send to the user.
              <strong>Note:</strong> In order for this to work, a schedule task will be created to perform the
              send email function every 12am midnight. You may follow this <a href="">guidelines</a> to setting
              up the task.';

        $this->contents['LANG_SEND_EMAIL'] = 'Send Email Reminder';
	}
}
?>