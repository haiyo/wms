<?php
namespace Markaxis\Company;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: OfficeRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class OfficeRes extends Resource {


    // Properties


    /**
     * OfficeRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_OFFICE'] = 'Văn phòng';
        $this->contents['LANG_CREATE_NEW_OFFICE'] = 'Tạo văn phòng mới';
        $this->contents['LANG_OFFICE_NAME'] = 'Tên văn phòng';
        $this->contents['LANG_ADDRESS'] = 'Địa chỉ';
        $this->contents['LANG_COUNTRY'] = 'Quốc gia';
        $this->contents['LANG_WORK_DAYS'] = 'Ngày làm việc';
        $this->contents['LANG_TOTAL_EMPLOYEE'] = 'Tổng số nhân viên';
        $this->contents['LANG_ENTER_OFFICE_NAME'] = 'Nhập tên văn phòng';
        $this->contents['LANG_OFFICE_ADDRESS'] = 'Địa chỉ văn phòng';
        $this->contents['LANG_ENTER_OFFICE_ADDRESS'] = 'Nhập địa chỉ văn phòng';
        $this->contents['LANG_OFFICE_COUNTRY'] = 'Văn phòng Quốc gia';
        $this->contents['LANG_OFFICE_TYPE'] = 'Loại văn phòng';
        $this->contents['LANG_WORKING_DAY_FROM'] = 'Ngày làm việc Từ';
        $this->contents['LANG_WORKING_DAY_TO'] = 'Ngày làm việc Tới';
        $this->contents['LANG_LAST_DAY_IS_HALF_DAY'] = 'Ngày cuối cùng là nửa ngày';
        $this->contents['LANG_SELECT_COUNTRY'] = 'Chọn quốc gia';
        $this->contents['LANG_SELECT_OFFICE_TYPE'] = 'Chọn loại văn phòng';
        $this->contents['LANG_SELECT_WORK_DAY_TO'] = 'Chọn Ngày làm việc Tới';
        $this->contents['LANG_SELECT_WORK_DAY_FROM'] = 'Chọn ngày làm việc từ';
        $this->contents['LANG_MUST_AT_LEAST_ONE_MAIN'] = 'Phải có ít nhất 1 văn phòng chính';
        $this->contents['LANG_EDIT_OFFICE'] = 'Chỉnh sửa văn phòng';
        $this->contents['LANG_PLEASE_ENTER_OFFICE_NAME'] = 'Vui lòng nhập Tên văn phòng';
        $this->contents['LANG_PLEASE_SELECT_COUNTRY'] = 'Vui lòng chọn quốc gia hoạt động';
        $this->contents['LANG_CREATE_ANOTHER_OFFICE'] = 'Tạo một văn phòng khác';
        $this->contents['LANG_MAIN'] = 'Chủ yếu';
        $this->contents['LANG_DELETE_OFFICE'] = 'Xóa văn phòng';
        $this->contents['LANG_SEARCH_OFFICE'] = 'Văn phòng tìm kiếm';
    }
}
?>