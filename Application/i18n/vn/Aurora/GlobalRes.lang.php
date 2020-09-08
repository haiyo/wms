<?php
namespace Aurora;
use \Resource;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: GlobalRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class GlobalRes extends Resource {


    // Properties


    /**
     * PayrollRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_NO'] = 'No';
        $this->contents['LANG_YES'] = 'Yes';
        $this->contents['LANG_BACK'] = 'Trở lại';
        $this->contents['LANG_NEXT'] = 'Kế tiếp';
        $this->contents['LANG_SHOW'] = 'Chỉ';
        $this->contents['LANG_DONE'] = 'Làm xong';
        $this->contents['LANG_CLOSE'] = 'Close';
        $this->contents['LANG_ERROR'] = 'lỗi';
        $this->contents['LANG_CONFIRM'] = 'Xác nhận';
        $this->contents['LANG_CANCEL'] = 'Huỷ bỏ';
        $this->contents['LANG_CANCELLED'] = 'Đã hủy';
        $this->contents['LANG_SUBMIT'] = 'Gửi đi';
        $this->contents['LANG_ACTIONS'] = 'Hành động';
        $this->contents['LANG_BROWSE'] = 'Duyệt qua';
        $this->contents['LANG_DELETE'] = 'Xóa bỏ';
        $this->contents['LANG_TABLE_ENTRIES'] = 'Hiển thị _START_ đến _END_ trong số _TOTAL_ mục nhập';
        $this->contents['LANG_NO_FILE_SELECTED'] = 'Không có tập tin được chọn';
        $this->contents['LANG_FILE_DELETED_UNDONE'] = 'Tệp bị xóa sẽ không thể khôi phục lại';
        $this->contents['LANG_BULK_ACTION'] = 'Hành động hàng loạt';
        $this->contents['LANG_CONFIRM_DELETE'] = 'Xác nhận Xóa';
        $this->contents['LANG_CONFIRM_CANCEL'] = 'Xác nhận Hủy bỏ';
        $this->contents['LANG_DESCRIPTION'] = 'Sự miêu tả';
        $this->contents['LANG_PLEASE_HOLD_REFRESH'] = 'Vui lòng giữ trong khi trang đang được làm mới';
        $this->contents['LANG_PROVIDE_ALL_REQUIRED'] = 'Vui lòng cung cấp tất cả các trường bắt buộc';
        $this->contents['LANG_INVALID_DATE_RANGE'] = 'Đã chọn phạm vi ngày không hợp lệ';
        $this->contents['LANG_CLOSE_WINDOW'] = 'Đóng cửa sổ';
        $this->contents['LANG_WHAT_TO_DO_NEXT'] = 'Bạn muốn làm gì tiếp theo?';
        $this->contents['LANG_PENDING_APPROVAL'] = 'Chờ phê duyệt';
        $this->contents['LANG_PENDING'] = 'Đang chờ xử lý';
        $this->contents['LANG_APPROVED'] = 'Tán thành';
        $this->contents['LANG_DISAPPROVED'] = 'Bị từ chối';
        $this->contents['LANG_NUMBER_ROWS'] = 'Số hàng';
        $this->contents['LANG_PREV'] = 'Trước đó';
        $this->contents['LANG_FIRST'] = 'Đầu tiên';
        $this->contents['LANG_LAST'] = 'Cuối cùng';
        $this->contents['LANG_NO_OF_EMPLOYEE'] = 'Số lượng nhân viên';
        $this->contents['LANG_UPLOAD_SUPPORTING_DOCUMENT'] = 'Tải lên Tài liệu Hỗ trợ (Nếu có)';
        $this->contents['LANG_ACCEPTED_FORMATS'] = 'Các định dạng được chấp nhận: pdf, doc. Kích thước tệp tối đa';
        $this->contents['LANG_APPROVING_MANAGERS'] = 'Người quản lý phê duyệt';
        $this->contents['LANG_ENTER_MANAGER_NAME'] = 'Nhập tên người quản lý';

        $this->contents['LANG_SUCCESSFULLY_CREATED'] = '{title} đã được tạo thành công!';
        $this->contents['LANG_ARE_YOU_SURE_DELETE'] = 'Bạn có chắc chắn muốn xóa {title} không';
        $this->contents['LANG_SUCCESSFULLY_DELETE'] = '{title} đã được xóa thành công!';
        $this->contents['LANG_ITEMS_SUCCESSFULLY_DELETED'] = '{count} mục đã được xóa thành công!';
        $this->contents['LANG_CANNOT_UNDONE_DELETED'] = 'Không thể hoàn tác hành động này sau khi đã xóa';
    }
}
?>