<?php
namespace Aurora\Config;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Thursday, August 2nd, 2012
 * @version $Id: SMTPRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class SMTPRes extends Resource {


    // Properties


    /**
    * SMTPRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_CONFIGURATIONS'] = 'Testing SMTP Configurations';
        $this->contents['LANG_SMTP_EMAIL'] = 'Use SMTP Server for Outgoing Email';
        $this->contents['LANG_SMTP_EMAIL_DESC'] = 'Use your preferred SMTP Server to send all outgoing email instead of the local mail server.';
        $this->contents['LANG_SMTP_CONFIG'] = 'Configure SMTP Settings';
        $this->contents['LANG_SMTP_ADDRESS'] = 'SMTP Server Address';
        $this->contents['LANG_SMTP_ADDRESS_DESC'] = 'Provide an IP address or domain name to the server which will be used for sending
              outgoing email.';
        $this->contents['LANG_SMTP_SERVER_PORT'] = 'SMTP Server Port';
        $this->contents['LANG_SMTP_SERVER_PORT_DESC'] = 'Provide the port which the SMTP server is using for connection.';
        $this->contents['LANG_SMTP_AUTHENTICATION'] = 'Authentication Method for SMTP';
        $this->contents['LANG_SMTP_AUTHENTICATION_DESC'] = 'The method to use when connecting to the specified SMTP server.
              This only applies if an SMTP username and password are set, and required by the server.';

        $this->contents['LANG_SMTP_SEND_TEST'] = 'Send A Test Email';
        $this->contents['LANG_SMTP_SEND_TEST_DESC'] = 'Send an email to test whether the SMTP configuration
                                                       works to the FIRST Webmaster email address.';



        $this->contents['LANG_PROVIDE_SMTP_ADDRESS'] = 'Please provide the SMTP address of the server.';
        $this->contents['LANG_PROVIDE_SMTP_PORT'] = 'Please provide the SMTP port of the server.';
        $this->contents['LANG_LAUNCH_TEST'] = 'Click Here to Launch Test';
        $this->contents['LANG_SMTP_CONNECTION'] = 'Connection Security';
        $this->contents['LANG_SMTP_CONNECTION_DESC'] = 'Select a connection type to connect to the mail server.';
        $this->contents['LANG_SMTP_USERNAME'] = 'SMTP Username';
        $this->contents['LANG_SMTP_USERNAME_DESC'] = 'Enter a Username only if the server requires it.';
        $this->contents['LANG_SMTP_PASSWORD'] = 'SMTP Password';
        $this->contents['LANG_SMTP_PASSWORD_DESC'] = 'Enter a Password only if the server requires it.';
        $this->contents['LANG_PROVIDE_WEBMASTER'] = 'Provide at least 1 webmaster email address for SMTP test.';
	}
}
?>