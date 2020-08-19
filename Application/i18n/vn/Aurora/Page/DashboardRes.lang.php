<?php
namespace Aurora\Page;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: DashboardRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DashboardRes extends Resource {


    /**
     * DashboardRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_DASHBOARD'] = 'bảng điều khiển';
        $this->contents['LANG_HELLO'] = 'xin chào';
        $this->contents['LANG_WELCOME'] = 'Chào mừng';
        $this->contents['LANG_DASHBOARD_INTRO'] = 'Bạn đang xem HRMS, công cụ mới cho công việc của bạn. Dưới đây là một cái nhìn nhanh về một số điều bạn có thể làm ở đây trong HRMS.';
        $this->contents['LANG_MY_LEAVE'] = 'Ngày phép của tôi';
        $this->contents['LANG_LEAVE_INTRO'] = 'Kiểm tra số dư nghỉ phép, trạng thái phê duyệt và lịch sử của bạn';
        $this->contents['LANG_MY_CALENDAR'] = 'Lịch của tôi';
        $this->contents['LANG_CALENDAR_INTRO'] = 'Tìm hiểu bất kỳ sự kiện hoặc kế hoạch nào';
        $this->contents['LANG_STAFF_DIRECTORY'] = 'Danh bạ nhân viên';
        $this->contents['LANG_STAFF_INTRO'] = 'Tìm kiếm đồng nghiệp và thông tin liên hệ của họ';
        $this->contents['LANG_EXPENSES_CLAIMS'] = 'Yêu cầu bồi thường chi phí';
        $this->contents['LANG_CLAIMS_INTRO'] = 'Gửi yêu cầu hoặc kiểm tra trạng thái phê duyệt';
        $this->contents['LANG_MY_PAYSLIP'] = 'Payslips của tôi';
        $this->contents['LANG_PAYSLIP_INTRO'] = 'Xem lịch sử hoặc tải xuống phiếu lương hàng tháng của bạn';
        $this->contents['LANG_LOA'] = 'Thư bổ nhiệm';
        $this->contents['LANG_LOA_INTRO'] = 'Truy cập Thư hẹn của bạn';
        $this->contents['LANG_PENDING_ACTIONS'] = 'Hành động đang chờ xử lý';
        $this->contents['LANG_NO_PENDING_ACTION'] = 'Bạn không có hành động nào đang chờ xử lý vào lúc này';
        $this->contents['LANG_LATEST_REQUESTS'] = 'Yêu cầu mới nhất';
        $this->contents['LANG_NO_LATEST_REQUEST'] = 'Bạn chưa đưa ra bất kỳ yêu cầu nào vào lúc này';
        $this->contents['LANG_DAYS_AVAILABLE'] = 'Ngày có sẵn';
        $this->contents['LANG_APPLY_LEAVE_NOW'] = 'Xin nghỉ ngay';
    }
}
?>