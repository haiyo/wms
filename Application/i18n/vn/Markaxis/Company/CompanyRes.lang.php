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
        $this->contents['LANG_COMPANY'] = 'Công ty';
        $this->contents['LANG_MY_COMPANY_BENEFITS'] = 'Lợi ích của công ty tôi';
        $this->contents['LANG_COMPANY_SETTINGS'] = 'Cài đặt công ty';
        $this->contents['LANG_UPLOAD_LOGO'] = 'Tải lên biểu trưng';
        $this->contents['LANG_MAIN_PORTAL_LOGO'] = 'Biểu trưng Cổng chính (Ưu tiên 425px x 116px)';
        $this->contents['LANG_CHOOSE_A_FILE'] = 'Chọn một tệp';
        $this->contents['LANG_PAYSLIP_LOGO'] = 'Biểu trưng Payslip (Ưu tiên 425px x 116px)';
        $this->contents['LANG_PAYSLIP'] = 'Payslip';
        $this->contents['LANG_COMPANY_REGISTRATION'] = 'Số đăng ký công ty';
        $this->contents['LANG_OFFICIAL_REGISTRATION'] = 'Số đăng ký chính thức';
        $this->contents['LANG_COMPANY_NAME'] = 'Tên công ty';
        $this->contents['LANG_COMPANY_ADDRESS'] = 'địa chỉ công ty';
        $this->contents['LANG_COMPANY_EMAIL'] = 'Email công ty';
        $this->contents['LANG_COMPANY_PHONE'] = 'Điện thoại công ty';
        $this->contents['LANG_COMPANY_WEBSITE'] = 'trang web của công ty';
        $this->contents['LANG_COMPANY_TYPE'] = 'Loại hình doanh nghiệp';
        $this->contents['LANG_MAIN_OPERATION_COUNTRY'] = 'Quốc gia hoạt động chính';
        $this->contents['LANG_MAIN_THEME_COLOR'] = 'Màu chủ đề chính';
        $this->contents['LANG_NAVIGATION_COLOR'] = 'Màu điều hướng';
        $this->contents['LANG_NAVIGATION_TEXT_COLOR'] = 'Màu văn bản điều hướng';
        $this->contents['LANG_NAVIGATION_TEXT_HOVER_COLOR'] = 'Di chuột văn bản điều hướng';
        $this->contents['LANG_DASHBOARD_BACKGROUND_COLOR'] = 'Màu nền của bảng điều khiển';
        $this->contents['LANG_BUTTONS_COLOR'] = 'Các nút màu';
        $this->contents['LANG_BUTTONS_HOVER_COLOR'] = 'Nút di chuột màu';
        $this->contents['LANG_BUTTONS_FOCUS_COLOR'] = 'Các nút lấy nét màu';
        $this->contents['LANG_SAVE_SETTINGS'] = 'Lưu các thiết lập';
    }
}
?>