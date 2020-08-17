<?php
namespace Aurora;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: NavRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NavRes extends Resource {


    /**
    * NavRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        
        $this->contents = array( );
                
        $this->contents['LANG_SYSTEM_CONTROL'] = 'System Control';
        $this->contents['LANG_CONFIGURATIONS'] = 'System Configurations';
        $this->contents['LANG_APPLICATION_MANAGEMENT'] = 'Application Management';
        $this->contents['LANG_SERVER_INFORMATION'] = 'Server Information';
        $this->contents['LANG_DROPLET_CUSTOMIZE'] = 'Droplets Customization';
        $this->contents['LANG_FIRMWARE_UPDATES'] = 'Firmware Updates';
        $this->contents['LANG_SIGN_OUT'] = 'Sign Out';
        $this->contents['LANG_SIGN_OUT_CONFIRM'] = 'Sign out of {WEBSITE_NAME}?';
        $this->contents['LANG_UPLOAD_LOGO'] = 'Upload Your Company Logo';
        $this->contents['LANG_SELECT_IMAGE'] = 'Select an image file on your computer (4MB max):';
	}
}
?>