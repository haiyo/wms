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
        $this->contents['LANG_SSN'] = 'Số hộ chiếu';
        $this->contents['LANG_NATIONALITY'] = 'Quốc tịch';
        $this->contents['LANG_PRIMARY_EMAIL'] = 'Địa chỉ Email Chính';
        $this->contents['LANG_SECONDARY_EMAIL'] = 'Địa chỉ Email Phụ';
        $this->contents['LANG_DATE_OF_BIRTH'] = 'Ngày sinh';
        $this->contents['LANG_PRIMARY_PHONE'] = 'Điện thoại chính';
        $this->contents['LANG_HOME_OFFICE_PHONE'] = 'Trang Chủ / Điện thoại văn phòng';
        $this->contents['LANG_MOBILE_PHONE'] = 'Điện thoại di động';
        $this->contents['LANG_ENTER_PHONE'] = 'Nhập điện thoại';
        $this->contents['LANG_COUNTRY_BIRTH'] = 'Quê hương';
        $this->contents['LANG_PRIMARY_ADDRESS'] = 'Địa chỉ chính';
        $this->contents['LANG_PREFERRED_LANGUAGE'] = 'Ngôn ngữ ưa thích';
        $this->contents['LANG_SELECT_LANGUAGE'] = 'Chọn ngôn ngữ';
        $this->contents['LANG_SECONDARY_ADDRESS'] = 'Địa chỉ phụ';
        $this->contents['LANG_GENDER'] = 'Giới tính';
        $this->contents['LANG_JOIN_DATE'] = 'Ngày tham gia';
        $this->contents['LANG_ACCOUNT_STATUS'] = 'Tình trạng tài khoản';
        $this->contents['LANG_COMPANY'] = 'Công ty';
        $this->contents['LANG_JOB_TITLE'] = 'Chức vụ';
        $this->contents['LANG_STREET_ADDRESS'] = 'Địa chỉ đường phố';
        $this->contents['LANG_COUNTRY'] = 'Quốc gia';
        $this->contents['LANG_ZIP_CODE'] = 'Mã bưu điện';
        $this->contents['LANG_STATE_PROVINCE'] = 'Tỉnh';
        $this->contents['LANG_CITY'] = 'Tp.';
        $this->contents['LANG_SELECT_STATE'] = 'Chọn tiểu bang';
        $this->contents['LANG_SELECT_CITY'] = 'Lựa chọn thành phố';
        $this->contents['LANG_RELIGION'] = 'Tôn giáo';
        $this->contents['LANG_RACE'] = 'Cuộc đua';
        $this->contents['LANG_MARITAL_STATUS'] = 'Tình trạng hôn nhân';
        $this->contents['LANG_HAVE_CHILDREN'] = 'Có trẻ em?';
        $this->contents['LANG_ENTER_CHILDREN_INFO'] = 'Nhập thông tin trẻ em';
        $this->contents['LANG_CHILD_FULL_NAME'] = 'Tên đầy đủ của trẻ';
        $this->contents['LANG_ADD_MORE_CHILDREN'] = 'Thêm nhiều trẻ em hơn';
        $this->contents['LANG_ACCOUNT_LOGIN'] = 'Đăng nhập tài khoản';
        $this->contents['LANG_LOGIN_USERNAME'] = 'Tên đăng nhập';
        $this->contents['LANG_LOGIN_PASSWORD'] = 'Mật khẩu đăng nhập';
        $this->contents['LANG_AUTO_GENERATE'] = 'Tự động tạo';
        $this->contents['LANG_CAPS_LOCK_ON'] = 'CHÌA KHÓA CAPS BẬT';
        $this->contents['LANG_PASSWORD'] = 'Mật khẩu';
        $this->contents['LANG_EMAIL_RANDOM_PASSWORD'] = 'Gửi mật khẩu ngẫu nhiên qua email';
        $this->contents['LANG_CONFIRMATION_PASSWORD'] = 'Mật khẩu xác nhận';
        $this->contents['LANG_ASSIGN_ROLES'] = 'Chỉ định vai trò (tối đa 5)';
        $this->contents['LANG_DEFAULT_ROLE'] = 'Vai trò mặc định';
        $this->contents['LANG_NONE'] = 'không ai';
        $this->contents['LANG_NOTES'] = 'Ghi chú';
        $this->contents['LANG_CANCEL'] = 'Huỷ bỏ';
        $this->contents['LANG_SAVE'] = 'Tiết kiệm';
        $this->contents['LANG_YEAR'] = 'Năm';
        $this->contents['LANG_MONTH'] = 'Tháng';
        $this->contents['LANG_DAY'] = 'Ngày';
        $this->contents['LANG_SELECT_COUNTRY'] = 'Chọn quốc gia';
        $this->contents['LANG_SELECT_NATIONALITY'] = 'Chọn quốc tịch';
        $this->contents['LANG_SELECT_RACE'] = 'Chọn cuộc đua';
        $this->contents['LANG_SELECT_STATUS'] = 'Chọn trạng thái';
        $this->contents['LANG_SELECT_RELIGION'] = 'Chọn tôn giáo';
	}
}
?>