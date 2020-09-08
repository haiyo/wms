<?php
namespace Markaxis\Leave;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: HolidayRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class HolidayRes extends Resource {


    // Properties


    /**
     * HolidayRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_EDIT_HOLIDAY'] = 'Chỉnh sửa ngày lễ';
        $this->contents['LANG_CREATE_CUSTOM_HOLIDAY'] = 'Tạo ngày lễ tùy chỉnh';
        $this->contents['LANG_ENTER_HOLIDAY_TITLE'] = 'Vui lòng nhập Tiêu đề ngày lễ';
        $this->contents['LANG_SELECT_DATE'] = 'Vui lòng chọn một ngày';
        $this->contents['LANG_HOLIDAY_CREATED_SUCCESSFULLY'] = 'Kỳ nghỉ được tạo thành công';
        $this->contents['LANG_HOLIDAY_CREATED_SUCCESSFULLY_DESCRIPT'] = 'Kỳ nghỉ mới đã được tạo thành công';
        $this->contents['LANG_HOLIDAY_UPDATED_SUCCESSFULLY'] = 'Đã cập nhật ngày lễ thành công';
        $this->contents['LANG_HOLIDAY_UPDATED_SUCCESSFULLY_DESCRIPT'] = 'Ngày lễ đã được cập nhật thành công';
        $this->contents['LANG_DELETE_HOLIDAY'] = 'Xóa ngày lễ';
        $this->contents['LANG_SEARCH_HOLIDAY'] = 'Tìm kiếm kỳ nghỉ';
        $this->contents['LANG_TITLE'] = 'Tiêu đề';
        $this->contents['LANG_COUNTRY'] = 'Quốc gia';
        $this->contents['LANG_DATE'] = 'Ngày';
        $this->contents['LANG_WORK_DAY'] = 'Ngày làm việc';
        $this->contents['LANG_HOLIDAYS'] = 'Ngày lễ';
        $this->contents['LANG_HOLIDAY_TITLE'] = 'Tiêu đề ngày lễ';
        $this->contents['LANG_ENTER_HOLIDAY_TITLE'] = 'Nhập tiêu đề cho ngày lễ này';
        $this->contents['LANG_IS_THIS_WORK_DAY'] = 'Đây có phải là một ngày làm việc?';
    }
}
?>