<?php
namespace Markaxis\Employee;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: EmployeeRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EmployeeRes extends Resource {


    // Properties


    /**
     * EmployeeRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_EMPLOYEE_DIRECTORY'] = 'Danh bạ nhân viên';
        $this->contents['LANG_ADD_NEW_EMPLOYEE'] = 'Thêm nhân viên mới';
        $this->contents['LANG_EDIT_EMPLOYEE_INFO'] = 'Chỉnh sửa thông tin nhân viên';
        $this->contents['LANG_EDIT_PROFILE'] = 'Chỉnh sửa hồ sơ';
        $this->contents['LANG_EMPLOYEE_TIMESHEET'] = 'Bảng chấm công nhân viên';
        $this->contents['LANG_EMPLOYEE_SETTINGS'] = 'Cài đặt nhân viên';
        $this->contents['LANG_EMPLOYEE'] = 'Nhân viên';
        $this->contents['LANG_EMPLOYEE_ID'] = 'Nhân viên ID';
        $this->contents['LANG_DESIGNATION'] = 'Chỉ định';
        $this->contents['LANG_DEPARTMENT'] = 'Phòng ban';
        $this->contents['LANG_MORE_DEPARTMENTS'] = 'Phòng ban khác';
        $this->contents['LANG_CONTRACT_TYPE'] = 'Thể loại hợp đồng';
        $this->contents['LANG_WORK_PASS'] = 'Work Pass';
        $this->contents['LANG_EMPLOYMENT_START_DATE'] = 'Ngày bắt đầu làm việc';
        $this->contents['LANG_EMPLOYMENT_END_DATE'] = 'Ngày kết thúc việc làm';
        $this->contents['LANG_EMPLOYMENT_CONFIRM_DATE'] = 'Ngày xác nhận việc làm';
        $this->contents['LANG_SEARCH_NAME_EMAIL'] = 'Tìm kiếm Tên hoặc Email';
        $this->contents['LANG_FILTER_BY_DESIGNATION'] = 'Lọc theo chỉ định';
        $this->contents['LANG_FILTER_BY_DEPARTMENT'] = 'Lọc theo phòng ban';
        $this->contents['LANG_DIFF_YEAR'] = 'yr';
        $this->contents['LANG_DIFF_MONTH'] = 'mth';
        $this->contents['LANG_DIFF_DAY'] = 'd';
        $this->contents['LANG_COMPETENCY_INFO'] = 'Thêm nhiều năng lực để nhân viên đủ điều kiện tham gia các Khóa học hoặc để đặt tiêu chí cho các yêu cầu phức tạp khác về Thuế của Chính phủ khi bạn thực hiện Tính lương cho nhân viên này';
        $this->contents['LANG_EMPLOYEE_SETUP'] = 'Thiết lập nhân viên';
        $this->contents['LANG_EMPLOYEE_ID'] = 'Số nhân viên';
        $this->contents['LANG_ASSIGN_DEPARTMENT'] = 'Phân công bộ phận';
        $this->contents['LANG_OFFICE_LOCATION'] = 'Văn phòng / Vị trí';
        $this->contents['LANG_SELECT_OFFICE_LOCATION'] = 'Chọn văn phòng / Vị trí';
        $this->contents['LANG_ASSIGN_DESIGNATION'] = 'Chỉ định Chỉ định';
        $this->contents['LANG_ASSIGN_MANAGERS'] = 'Chỉ định người quản lý';
        $this->contents['LANG_ENTER_MANAGER_NAME'] = 'Nhập tên người quản lý';
        $this->contents['LANG_ASSIGN_ROLE'] = 'Chỉ định vai trò';
        $this->contents['LANG_SELECT_DESIGNATION'] = 'Chọn chỉ định';
        $this->contents['LANG_BASIC_SALARY'] = 'Lương cơ bản';
        $this->contents['LANG_SALARY_TYPE'] = 'Loại lương';
        $this->contents['LANG_SELECT_CONTRACT_TYPE'] = 'Chọn loại hợp đồng';
        $this->contents['LANG_SELECT_PASS_TYPE'] = 'Chọn loại thẻ';
        $this->contents['LANG_SELECT_ROLES'] = 'Chọn vai trò';
        $this->contents['LANG_SELECT_DEPARTMENTS'] = 'Chọn bộ phận';
        $this->contents['LANG_YEAR'] = 'Năm';
        $this->contents['LANG_MONTH'] = 'Tháng';
        $this->contents['LANG_DAY'] = 'Ngày';
        $this->contents['LANG_ADD_EMPLOYEE_COMPETENCIES'] = 'Thêm năng lực của nhân viên';
        $this->contents['LANG_TYPE_ADD_NEW_COMPETENCY'] = 'Nhập và nhấn Enter để thêm năng lực mới';
        $this->contents['LANG_ENTER_SKILLSETS_KNOWLEDGE'] = 'Nhập các bộ kỹ năng hoặc kiến thức';
        $this->contents['LANG_FOR_FOREIGNER'] = 'Đối với người nước ngoài';
        $this->contents['LANG_WORK_PASS_TYPE'] = 'Loại thẻ công việc';
        $this->contents['LANG_WORK_PASS_NUMBER'] = 'Số thẻ làm việc';
        $this->contents['LANG_WORK_PASS_EXPIRY_DATE'] = 'Ngày hết hạn thẻ làm việc';

        $this->contents['LANG_HR_INFORMATION'] = 'Thông tin nhân sự';
        $this->contents['LANG_CONTACT'] = 'Tiếp xúc';
        $this->contents['LANG_NAME'] = 'Tên';
        $this->contents['LANG_EMPLOYMENT_STATUS'] = 'Tình trạng việc làm';
        $this->contents['LANG_EMAIL'] = 'E-mail';
        $this->contents['LANG_MOBILE'] = 'Di động';
        $this->contents['LANG_ACTIONS'] = 'Hành động';
    }
}
?>