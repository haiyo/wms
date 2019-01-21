<?php
namespace Aurora\Config;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: CoreRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CoreRes extends Resource {


    // Properties


    /**
    * CoreRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_MENU_TITLE'] = 'System Configurations';
        $this->contents['LANG_MENU_LINK_TITLE'] = 'Aurora Core Settings';
        $this->contents['LANG_SYS_MAINTENANCE'] = 'System Maintenance Mode';
        $this->contents['LANG_SYS_MAINTENANCE_DESC'] = 'Turn ON maintenance mode to disallow all users from
                              using or logging into the system <strong>except for
                              Administrator(s)</strong>. All existing users currently
                              using the system will be logged out.';
        $this->contents['LANG_COMPANY_NAME'] = 'Company Name';
        $this->contents['LANG_COMPANY_NAME_DESC'] = 'Specify a name that represent you or the Company which will appear
                              to the user.';
        $this->contents['LANG_COMPANY_ADDRESS'] = 'Company Address';
        $this->contents['LANG_COMPANY_ADDRESS_DESC'] = 'Specify your company address (if any) which will appear
                              to the user for any application which may of use.';

        $this->contents['LANG_COMPANY_WEBSITE'] = 'Company Website';
        $this->contents['LANG_COMPANY_WEBSITE_DESC'] = 'Specify your company website address (if any) which will appear
                              to the user for any application which may of use.';

        $this->contents['LANG_COMPANY_PHONE'] = 'Company Phone';
        $this->contents['LANG_COMPANY_PHONE_DESC'] = 'Specify your company contact (if any) which will appear
                              to the user for any application which may of use.';

        $this->contents['LANG_COMPANY_FAX'] = 'Company Fax';
        $this->contents['LANG_COMPANY_FAX_DESC'] = 'Specify your company fax (if any) which will appear
                              to the user for any application which may of use.';

        $this->contents['LANG_URL_PROTOCOL'] = 'URL Transfer Protocol';
        $this->contents['LANG_URL_PROTOCOL_DESC'] = 'Select the type of protocol Aurora should be running on. Check
                              with the hosting provider If a secure certificate is available, and if so, select the
                              https:// secure mode. Re-login is necessary if changes is made.';
        $this->contents['LANG_DOMAIN_URL'] = 'Domain URL';
        $this->contents['LANG_DOMAIN_URL_DESC'] = 'The Domain URL to the Aurora System. Entering an invalid URL will
                              leaves you unable to access the system.';
        $this->contents['LANG_COOKIE_PATH'] = 'Cookie Path';
        $this->contents['LANG_COOKIE_PATH_DESC'] = 'If more than one instance of the Aurora System is installed in the same domain, set
                              this path to point to current folder.';
        $this->contents['LANG_COOKIE_DOMAIN'] = 'Cookie Domain';
        $this->contents['LANG_COOKIE_DOMAIN_DESC'] = 'If there are 2 or more different URLs to access the Aurora System (i.e example.com and
              aurora.example.com), set this to .example.com (note the beginning dot)';
        $this->contents['LANG_MAIL_FROM_NAME'] = 'Email Name of Sender';
        $this->contents['LANG_MAIL_FROM_NAME_DESC'] = 'When Aurora send out a system email, this name will appear in the From field to the recipient.';
        $this->contents['LANG_MAIL_FROM_EMAIL'] = 'Email of Sender';
        $this->contents['LANG_MAIL_FROM_EMAIL_DESC'] = 'When Aurora send out a system email, this email will appear in the From field to the recipient.';
        $this->contents['LANG_WEBMASTER_EMAIL'] = 'Webmaster Email Addresses';
        $this->contents['LANG_WEBMASTER_EMAIL_DESC'] = 'All critical system errors and alert messages will be sent to the
              specified email addresses. You may configure more than one email address by entering one per line';
	}
}
?>