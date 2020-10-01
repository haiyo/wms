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
        $this->contents['LANG_EMPLOYMENT_START'] = 'Bắt đầu việc làm';
        $this->contents['LANG_EMPLOYMENT_END_DATE'] = 'Ngày kết thúc việc làm';
        $this->contents['LANG_EMPLOYMENT_CONFIRM_DATE'] = 'Ngày xác nhận việc làm';
        $this->contents['LANG_EMPLOYMENT_CONFIRM'] = 'Xác nhận việc làm';
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

        $this->contents['LANG_CONFIRM_SUSPEND_NAME'] = 'Bạn có chắc chắn muốn tạm ngưng {name}?';
        $this->contents['LANG_NO_LOGIN_HRS'] = 'Nhân viên này sẽ không thể đăng nhập vào Hệ thống HRS nữa';
        $this->contents['LANG_CONFIRM_UNSUSPEND'] = 'Bạn có chắc chắn muốn hủy sử dụng không {name}?';
        $this->contents['LANG_ABLE_LOGIN_HRS'] = 'Nhân viên này sẽ có thể đăng nhập vào Hệ thống HRS';
        $this->contents['LANG_CONFIRM_SUSPEND'] = 'Xác nhận tạm ngưng';
        $this->contents['LANG_CONFIRM_UNSUSPEND'] = 'Xác nhận chưa chi tiêu';
        $this->contents['LANG_PROVIDE_REASON'] = 'Cung cấp lý do nếu có';
        $this->contents['LANG_UNSUSPEND_EMPLOYEE'] = 'Nhân viên không sử dụng';
        $this->contents['LANG_SUSPENDED'] = 'Đình chỉ';
        $this->contents['LANG_RESIGNED'] = 'Đã từ chức';
        $this->contents['LANG_SUSPEND_EMPLOYEE'] = 'Đình chỉ nhân viên';
        $this->contents['LANG_ACTIVE'] = 'Hoạt động';
        $this->contents['LANG_SUCCESSFULLY_SUSPENDED'] = '{name} đã bị đình chỉ thành công!';
        $this->contents['LANG_SUCCESSFULLY_UNSUSPENDED'] = '{name} đã được hủy tạm dừng thành công!';
        $this->contents['LANG_SET_RESIGNED_EMPLOYEE'] = 'Đặt {name} làm Nhân viên đã thôi việc?';
        $this->contents['LANG_SET_UNRESIGNED_EMPLOYEE'] = 'Đặt {name} là Nhân viên chưa được bổ nhiệm?';
        $this->contents['LANG_CONFIRM_RESIGN'] = 'Xác nhận từ chức';
        $this->contents['LANG_CONFIRM_UNRESIGN'] = 'Xác nhận Hủy thiết kế';
        $this->contents['LANG_SUCCESSFULLY_RESIGNED'] = '{name} đã được đặt thành công thành Đã từ chức!';
        $this->contents['LANG_SUCCESSFULLY_UNRESIGNED'] = '{name} đã được đặt thành công thành chưa được chỉ định!';
        $this->contents['LANG_INACTIVE_SOON'] = 'Không hoạt động sớm';
        $this->contents['LANG_EDIT_EMPLOYEE_INFO'] = 'Chỉnh sửa nhân viên';
        $this->contents['LANG_EMPLOYEE_RESIGNED'] = 'Nhân viên đã từ chức';
        $this->contents['LANG_EMPLOYEE_UNRESIGNED'] = 'Nhân viên chưa được thuê';
        $this->contents['LANG_DELETE_EMPLOYEE'] = 'Xóa nhân viên';
        $this->contents['LANG_DELETE_EMPLOYEE_NAME'] = 'Xóa nhân viên - {name}';
        $this->contents['LANG_CONFIRM_DELETE'] = 'Xác nhận Xóa';
        $this->contents['LANG_SEARCH_EMPLOYEE'] = 'Tìm kiếm nhân viên, chức vụ hoặc loại hợp đồng';

        $this->contents['LANG_ENTER_VALID_CHILD'] = 'Vui lòng nhập thông tin con hợp lệ';
        $this->contents['LANG_ENTER_VALID_EMAIL'] = 'Vui lòng nhập địa chỉ email hợp lệ';
        $this->contents['LANG_CONFIRM_DELETE_PHOTO'] = 'Bạn có chắc chắn muốn xóa ảnh của {name} không?';
        $this->contents['LANG_PHOTO_DELETED_UNDONE'] = 'Ảnh đã xóa sẽ không thể khôi phục lại';
        $this->contents['LANG_PHOTO_SUCCESSFULLY_DELETED'] = 'Ảnh của {name} đã được xóa thành công!';
        $this->contents['LANG_EMPLOYEE_ADDED_SUCCESSFULLY'] = 'Nhân viên mới đã được thêm thành công';
        $this->contents['LANG_ADD_ANOTHER_EMPLOYEE'] = 'Thêm một nhân viên khác';
        $this->contents['LANG_GO_EMPLOYEE_LISTING'] = 'Đi tới Danh sách nhân viên';
        $this->contents['LANG_EMPLOYEE_UPDATED_SUCCESSFULLY'] = 'Đã cập nhật nhân viên thành công';
        $this->contents['LANG_CONTINUE_EDIT_EMPLOYEE'] = 'Tiếp tục Chỉnh sửa Nhân viên này';
        $this->contents['LANG_PROFILE_UPDATED'] = 'Hồ sơ của bạn đã được cập nhật thành công';
    }
}
?>