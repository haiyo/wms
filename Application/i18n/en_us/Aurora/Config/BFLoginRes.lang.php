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
        $this->contents['LANG_MENU_LINK_TITLE'] = 'Brute Force Login Protection';
        $this->contents['LANG_ENABLE_BF'] = 'Enable Brute Force Login Shield';
        $this->contents['LANG_ENABLE_BF_DESC'] = 'Prevent unauthorized user from using dictionary or manually guessing password in attempt to login to the system.';
        $this->contents['LANG_BF_NUM_OF_FAILED'] = 'Number of Failed Login Attempts';
        $this->contents['LANG_BF_NUM_OF_FAILED_DESC'] = 'Select the number of tries for a login to be attempted before any action taken.';
        $this->contents['LANG_ENFORCE_ACTION'] = 'Enforce Action';
        $this->contents['LANG_ENFORCE_ACTION_DESC'] = 'Select the type of action Aurora should perform after the number of times allowed for failed login attempt has exhausted.';
        $this->contents['LANG_BF_TIPS'] = '<strong>Tips:</strong> To strengthen this security feature even further, it is recommended to enable the "Enforce Strong Password" setting located in the <strong>Usage Policy Settings</strong>.';
        $this->contents['LANG_NO_ACTION'] = 'No Action';
        $this->contents['LANG_BLOCK_IP_FOR_N'] = 'Block IP address for {n} minutes';
        $this->contents['LANG_NEVER'] = 'Never';
        $this->contents['LANG_ONLY_EXHAUSTED'] = 'Only when fail exhausted';
        $this->contents['LANG_ALWAYS'] = 'Always include';
        $this->contents['LANG_SEND_EMAIL'] = 'Send Email Alert';
        $this->contents['LANG_SEND_EMAIL_DESC'] = 'Send an email alert to Webmaster on failed login attempt.';

        $this->contents['LANG_ALERT_SUBJECT'] = 'Brute Force Alert';
        $this->contents['LANG_ALERT_MSG'] = '{ip_address} has exceeded the maximum number of {num_failed} login and have been blocked for {bf_action} minutes.';
	}
}
?>