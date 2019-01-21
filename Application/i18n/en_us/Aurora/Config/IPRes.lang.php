<?php
namespace Aurora\Config;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: IPRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class IPRes extends Resource {


    // Properties


    /**
    * IPRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_MENU_TITLE'] = 'Security / Firewall Policy';
        $this->contents['LANG_MENU_LINK_TITLE'] = 'Country / IP Restrictions';
        $this->contents['LANG_ENABLE_IP'] = 'Enable Country / IP Address Restrictions';
        $this->contents['LANG_ENABLE_IP_DESC'] = 'Block or allow users from certain IP address/countries to access the Aurora System.';
        $this->contents['LANG_CONFIG_RESTRICT_POLICY'] = 'Configure Restriction Policy';
        $this->contents['LANG_RESTRICT_COUNTRY'] = 'Restrict Access by Country';
        $this->contents['LANG_RESTRICT_COUNTRY_DESC'] = 'You can choose to select the Countries you would like to <strong><u>block access</u></strong> to the Aurora System.<br /><br />
              If you wish to check the country origin of a particular IP address, you may do so from this <a href="http://ip2country.hackers.lv/" target="_blank">website</a>.';
        $this->contents['LANG_RESTRICT_IP'] = 'Restrict Access by IP Address';
        $this->contents['LANG_RESTRICT_IP_DESC'] = '<strong>IMPORTANT NOTE:</strong> White List is for
              <strong style="color:red;">MAXIMUM SECURITY</strong>. Only IP addresses in range or listed in
              the White List will be able to access the system. If your IP address is not in range or
              listed in the White List, you will not be able to access the system. Best recommendation is to leave the White List blank.';
        $this->contents['LANG_FOR_EXAMPLE'] = 'For example';
        $this->contents['LANG_IP_EXAMPLES'] = '<div style="margin-bottom:3px;"><span style="font-weight:bold;">192.168.10.74</span> (Matches exactly this IP)</div>
                                               <div style="margin-bottom:3px;"><strong>192.168.10.*</strong> (Matches with Wildcard)</div>
                                               <div style="margin-bottom:3px;"><strong>192.168.10.1-192.168.10.100</strong> (Start-End Range)</div>
                                               <div style="margin-bottom:3px;"><strong>192.168.10.0/24</strong> (Matches CIDR - Classless Inter-Domain Routing)</div>';
        $this->contents['LANG_WHITE_LIST'] = 'White List (Only Allow)';
        $this->contents['LANG_BLACK_LIST'] = 'Black List (Do Not Allow)';
        $this->contents['LANG_ENTER_PER_LINE'] = 'Enter IP Address rule one per line below.';
        $this->contents['LANG_SEND_EMAIL'] = 'Send Email Alert';
        $this->contents['LANG_SEND_EMAIL_DESC'] = 'Send an email alert to Webmaster for any unauthorized access.';
	}
}
?>