<?php
namespace Aurora\User;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: UserRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserRes extends Resource {


    /**
    * UserRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        
        $this->contents = array( );
        $this->contents['LANG_FILTER_ROLE'] = '--- Lọc theo vai trò ---';
        $this->contents['LANG_ROLES_MANAGEMENT'] = 'Quản lý vai trò';
        $this->contents['LANG_USER_MANAGEMENT'] = 'Quản lý người dùng';
        $this->contents['LANG_CLOSE'] = 'Đóng';
        $this->contents['LANG_ADD_NEW'] = 'Tài khoản mới';
        $this->contents['LANG_DELETE'] = 'Xóa tài khoản';
        $this->contents['LANG_ROLES'] = 'Có {n} vai trò';
        $this->contents['LANG_NO_ROLES'] = 'Không có vai trò';
        $this->contents['LANG_PENDING'] = 'Đang chờ xử lý';
        $this->contents['LANG_SUSPENDED'] = 'Đình chỉ';
        $this->contents['LANG_ONLINE'] = 'Online';
        $this->contents['LANG_OFFLINE'] = 'Offline';
        $this->contents['LANG_AGE'] = 'tuổi tác';
        $this->contents['LANG_TITLE'] = 'Tên tài khoản';
        $this->contents['LANG_USER_NOT_FOUND'] = 'Không tìm thấy người dùng. Không thể truy xuất bản ghi.';
        $this->contents['LANG_PASSWORD_NOT_MATCHED'] = 'Mật khẩu không khớp. Vui lòng nhập lại mật khẩu.';
        $this->contents['LANG_ENTER_REQUIRED_FIELDS'] = 'Tên, họ và email là bắt buộc để tạo tài khoản.';
        $this->contents['LANG_INVALID_EMAIL'] = 'Địa chỉ email không hợp lệ.';
        $this->contents['LANG_USERNAME_ALREADY_EXIST'] = 'Tên người dùng đã tồn tại trong hồ sơ.';
        $this->contents['LANG_EMAIL_ALREADY_EXIST'] = 'Email đã tồn tại trong hồ sơ.';
        $this->contents['LANG_MUST_CHECK_USER'] = 'Nhấp vào hộp kiểm để chọn một hoặc nhiều tài khoản người dùng.';
        $this->contents['LANG_CONFIRM_DELETE'] = 'Bạn đã chọn xóa {n} tài khoản người dùng. | Các tài khoản. Việc xóa sẽ xóa tất cả thông tin được kết nối với tài khoản. \ N \ n Trước tiên, bạn nên tạm ngưng tài khoản và xác minh tất cả thông tin trước khi xóa. \ N \ nKhông thể hoàn tác hành động này.';
        $this->contents['LANG_CONFIRM_DELETE_CURRENT'] = 'Bạn có chắc chắn muốn xóa tài khoản của {name} không? Việc xóa sẽ xóa tất cả thông tin được kết nối với tài khoản. \ N \ n Trước tiên, bạn nên tạm ngưng tài khoản và xác minh tất cả thông tin trước khi xóa. \ N \ nKhông thể hoàn tác hành động này.';
        $this->contents['LANG_CONFIRM_REMOVE'] = 'Bạn có chắc chắn muốn xóa ảnh của {name} không?';
        $this->contents['LANG_NEW_ACCOUNT_CREATED'] = 'Tài khoản mới đã được tạo.';
        $this->contents['LANG_GENERATE_PWD'] = 'Không có mật khẩu nào được gán cho nhân viên này. Bạn có muốn hệ thống tạo một mật khẩu ngẫu nhiên và gửi cho người dùng không?';
        $this->contents['LANG_CLICK_TO_UPLOAD'] = 'Bấm vào đây để tải ảnh lên';
        $this->contents['LANG_SEARCH_FOR_PEOPLE'] = 'Tìm kiếm người';
        $this->contents['LANG_NO_RESULTS_FOUND'] = 'không tìm thấy kết quả nào';
        $this->contents['LANG_SEARCHING'] = 'Đang tìm kiếm...';
        $this->contents['LANG_CHOOSE_ACTION'] = 'Chọn một hành động để thực hiện';
        $this->contents['LANG_MORE_ACTIONS'] = 'Nhiêu hanh động hơn';
        $this->contents['LANG_TOTAL_RECORDS'] = 'Tổng số hồ sơ';
        $this->contents['LANG_PAGE'] = 'Trang';
        $this->contents['LANG_OF'] = 'của';
        $this->contents['LANG_SEARCH_BY_NAME'] = 'Tìm kiếm theo tên';
        $this->contents['LANG_IMPORT_EXPORT_CONTACTS'] = 'Nhập / Xuất Danh bạ';
        $this->contents['LANG_BIRTHDAY'] = 'Sinh nhật';
        $this->contents['LANG_EMPLOYEE_SINCE'] = 'Ngày nhân viên bắt đầu';
        // Form
        $this->contents['LANG_PERSONAL_INFORMATION'] = 'Thông tin cá nhân';
        $this->contents['LANG_OTHER_INFORMATION'] = 'Thông tin khác';
        $this->contents['LANG_SECURITY_ACCESS'] = 'Truy cập bảo mật';
        $this->contents['LANG_ADDITIONAL_NOTES'] = 'Ghi chú bổ sung';
        $this->contents['LANG_REMOVE_PHOTO'] = 'Gỡ bỏ hình';
        $this->contents['LANG_FIRST_NAME'] = 'Họ';
        $this->contents['LANG_LAST_NAME'] = 'Họ/ Tên';
        $this->contents['LANG_PRIMARY_EMAIL'] = 'Địa chỉ Email Chính';
        $this->contents['LANG_DATE_OF_BIRTH'] = 'Ngày sinh';
        $this->contents['LANG_PRIMARY_PHONE'] = 'Điện thoại chính';
        $this->contents['LANG_GENDER'] = 'Giới tính';
        $this->contents['LANG_JOIN_DATE'] = 'Ngày tham gia';
        $this->contents['LANG_ACCOUNT_STATUS'] = 'Account Status';
        $this->contents['LANG_COMPANY'] = 'Company';
        $this->contents['LANG_JOB_TITLE'] = 'Job Title';
        $this->contents['LANG_STREET_ADDRESS'] = 'Street address';
        $this->contents['LANG_COUNTRY'] = 'Country';
        $this->contents['LANG_ZIP_CODE'] = 'ZIP / Postal code';
        $this->contents['LANG_STATE_PROVINCE'] = 'State / Province';
        $this->contents['LANG_CITY'] = 'City';
        $this->contents['LANG_MARITAL_STATUS'] = 'Marital Status';
        $this->contents['LANG_PASSWORD'] = 'Password';
        $this->contents['LANG_EMAIL_RANDOM_PASSWORD'] = 'Email a random password';
        $this->contents['LANG_CONFIRMATION_PASSWORD'] = 'Confirmation Password';
        $this->contents['LANG_ASSIGN_ROLES'] = 'Assign Roles (max 5)';
        $this->contents['LANG_DEFAULT_ROLE'] = 'Default Role';
        $this->contents['LANG_NONE'] = 'None';
        $this->contents['LANG_NOTES'] = 'Notes';
        $this->contents['LANG_CANCEL'] = 'Cancel';
        $this->contents['LANG_SAVE'] = 'Save';
	}
}
?>