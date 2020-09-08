<?php
namespace Markaxis\Calendar;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: EventRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EventRes extends Resource {


    /**
    * EventRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        
        $this->contents = array( );
        $this->contents['LANG_DEFAULT_TITLE'] = 'Lịch sự kiện';
        $this->contents['LANG_CALENDAR_SETTINGS'] = 'Cài đặt lịch';
        $this->contents['LANG_RETRIEVE_EVENT_FROM'] = 'Lấy sự kiện từ';
        $this->contents['LANG_ADVANCED_DESCRIPT'] = 'If posting new events requires approval, all approving
                                                     officers including the Administrator will receive private
                                                     message and email notifications for new events posted.';
        $this->contents['LANG_NEW_EVENTS'] = 'Posting of New Events';
        $this->contents['LANG_APPROVING_OFFICERS'] = 'Approving Officer(s)';
        $this->contents['LANG_ADMIN_DEFAULT'] = 'Note: The Administrator is by default the approving officer.';
        $this->contents['LANG_UPCOMING_EVENT'] = 'Sự kiện sắp tới';
        $this->contents['LANG_NO_UPCOMING_EVENT'] = 'Không có sự kiện sắp diễn ra hôm nay';
        $this->contents['LANG_VIEW_CALENDAR'] = 'Xem lịch';
        $this->contents['LANG_EVENT_INFORMATION'] = 'Thông tin sự kiện';
        $this->contents['LANG_AGENDA'] = 'Lịch trình';
        $this->contents['LANG_AGENDA_LIST'] = 'Danh sách lịch trình';
        $this->contents['LANG_EVENT_NO_RECORD'] = 'Không có sự kiện nào vào ngày này.<br /><a href="" class="createSingle">Tạo sự kiện vào ngày này.</a>';
        $this->contents['LANG_ALL_DAY'] = 'Sự kiện cả ngày';
        $this->contents['LANG_CREATE_NEW_EVENT'] = 'Tạo sự kiện mới';
        $this->contents['LANG_RECUR_EDIT_NOTE'] = 'Lưu ý: Đây là một sự kiện lặp lại. Việc chỉnh sửa sự kiện này sẽ ảnh hưởng đến tất cả các lần xuất hiện khác';
        $this->contents['LANG_EDIT_EVENT'] = 'Chỉnh sửa sự kiện';
        $this->contents['LANG_SAVE_EVENT'] = 'Lưu sự kiện';
        $this->contents['LANG_DELETE_EVENT'] = 'Xóa sự kiện';
        $this->contents['LANG_EVENT_NOT_FOUND'] = 'Không tìm thấy sự kiện';
        $this->contents['LANG_EVENT_NOT_FOUND_MSG'] = '<strong>Sự kiện bạn đang tìm kiếm không thể tìm thấy.
                                                       Nó có thể đã bị ai đó thay đổi hoặc xóa gần đây.</strong>
                                                       <p>Hãy thử làm mới trang để nhận được những thay đổi cập nhật nhất.</p>';
        $this->contents['LANG_MANAGE_LABELS'] = 'Quản lý nhãn';
        $this->contents['LANG_IM_DONE'] = 'Tôi đã xong!';

        $this->contents['LANG_START'] = 'Ngày / Giờ bắt đầu';
        $this->contents['LANG_END'] = 'Ngày / Giờ kết thúc';
        $this->contents['LANG_EVENT_LABEL'] = 'Nhãn sự kiện';
        $this->contents['LANG_REPEAT'] = 'Nói lại';
        $this->contents['LANG_EVERY'] = 'Mỗi';
        $this->contents['LANG_TIMES'] = 'Times';
        $this->contents['LANG_DATE'] = 'Ngày';
        $this->contents['LANG_END_REPEAT'] = 'Kết thúc Lặp lại';
        $this->contents['LANG_VIEW_RSVP'] = 'Xem hoặc RSVP';
        $this->contents['LANG_LOCATION'] = 'Vị trí';
        $this->contents['LANG_RSVP'] = 'RSVP';
        $this->contents['LANG_SET_REMINDER'] = 'Thiết lập nhắc nhở';
        $this->contents['LANG_SET_REPEAT'] = 'Đặt Lặp lại';
        $this->contents['LANG_EMAIL_REMINDER'] = 'Email';
        $this->contents['LANG_POPUP_REMINDER'] = 'Popup';
        $this->contents['LANG_ENTER_TITLE'] = 'Vui lòng nhập tiêu đề sự kiện';


        $this->contents['LANG_PRIVACY_SETTING'] = 'Cài đặt cá nhân';
        $this->contents['LANG_PUBLIC'] = 'Công cộng';
        $this->contents['LANG_PRIVATE'] = 'Riêng tư';

        // Agenda
        $this->contents['LANG_UNTIL'] = 'cho đến khi';
        $this->contents['LANG_FULL_DAY'] = 'Cả ngày';
        $this->contents['LANG_PRIVATE_EVENT_BY'] = 'Sự kiện riêng tư của';
        $this->contents['LANG_PUBLIC_EVENT_BY'] = 'Sự kiện công khai bởi';
        $this->contents['LANG_EXPORT'] = 'Xuất khẩu';
        $this->contents['LANG_EVENT_CREATED'] = 'Sự kiện được tạo thành công';
        $this->contents['LANG_EVENT_CREATED_DESCRIPT'] = 'Sự kiện của bạn đã được tạo thành công.';
        $this->contents['LANG_EVENT_UPDATED'] = 'Đã cập nhật sự kiện thành công';
        $this->contents['LANG_EVENT_UPDATED_DESCRIPT'] = 'Sự kiện của bạn đã được cập nhật thành công.';
        $this->contents['LANG_CONFIRM_DELETE_EVENT'] = 'Bạn có chắc chắn muốn xóa sự kiện có tiêu đề {title}';
        $this->contents['LANG_CONFIRM_DELETE_EVENT_DESCRIPT'] = 'Sự kiện bị xóa sẽ không thể khôi phục lại.';
        $this->contents['LANG_EVENT_DELETED_SUCCESSFULLY'] = '{title} đã được xóa thành công!';
        $this->contents['LANG_INVALID_DATE_RANGE'] = 'Đã chọn phạm vi ngày không hợp lệ';
	}
}
?>