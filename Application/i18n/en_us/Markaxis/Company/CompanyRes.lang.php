<?php
namespace Markaxis\Company;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: CompanyRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CompanyRes extends Resource {


    // Properties


    /**
     * CompanyRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_COMPANY'] = 'Company';
        $this->contents['LANG_MY_COMPANY_BENEFITS'] = 'My Company Benefits';
        $this->contents['LANG_COMPANY_SETTINGS'] = 'Company Settings';
        $this->contents['LANG_UPLOAD_LOGO'] = 'Upload Logo';
        $this->contents['LANG_MAIN_PORTAL_LOGO'] = 'Main Portal Logo (425px by 116px Preferred)';
        $this->contents['LANG_CHOOSE_A_FILE'] = 'Choose a file';
        $this->contents['LANG_PAYSLIP_LOGO'] = 'Payslip Logo (425px by 116px Preferred)';
        $this->contents['LANG_PAYSLIP'] = 'Payslip';
        $this->contents['LANG_COMPANY_REGISTRATION'] = 'Company Registration Number';
        $this->contents['LANG_OFFICIAL_REGISTRATION'] = 'Official registration number';
        $this->contents['LANG_COMPANY_NAME'] = 'Company Name';
        $this->contents['LANG_COMPANY_ADDRESS'] = 'Company Address';
        $this->contents['LANG_COMPANY_EMAIL'] = 'Company Email';
        $this->contents['LANG_COMPANY_PHONE'] = 'Company Phone';
        $this->contents['LANG_COMPANY_WEBSITE'] = 'Company Website';
        $this->contents['LANG_COMPANY_TYPE'] = 'Company Type';
        $this->contents['LANG_MAIN_OPERATION_COUNTRY'] = 'Main Operation Country';
        $this->contents['LANG_MAIN_THEME_COLOR'] = 'Main Theme Color';
        $this->contents['LANG_NAVIGATION_COLOR'] = 'Navigation Color';
        $this->contents['LANG_NAVIGATION_TEXT_COLOR'] = 'Navigation Text Color';
        $this->contents['LANG_NAVIGATION_TEXT_HOVER_COLOR'] = 'Navigation Text Hover Color';
        $this->contents['LANG_DASHBOARD_BACKGROUND_COLOR'] = 'Dashboard Background Color';
        $this->contents['LANG_BUTTONS_COLOR'] = 'Buttons Color';
        $this->contents['LANG_BUTTONS_HOVER_COLOR'] = 'Buttons Hover Color';
        $this->contents['LANG_BUTTONS_FOCUS_COLOR'] = 'Buttons Focus Color';
        $this->contents['LANG_SAVE_SETTINGS'] = 'Save Settings';
    }
}
?>