<?php
namespace Markaxis\Calendar;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: CalendarRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarRes extends Resource {


    // Properties


    /**
     * CalendarRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_CALENDAR'] = 'Xem lịch';
        $this->contents['LANG_FILTER_EVENT_TYPES'] = 'Lọc các loại sự kiện';
        $this->contents['LANG_MY_EVENTS'] = 'Sự kiện của tôi';
        $this->contents['LANG_COLLEAGUE_EVENTS'] = 'Sự kiện đồng nghiệp';
        $this->contents['LANG_INCLUDE_BIRTHDAYS'] = 'Bao gồm sinh nhật';
        $this->contents['LANG_INCLUDE_HOLIDAYS'] = 'Bao gồm các ngày lễ';
        $this->contents['LANG_PUBLIC_EVENT'] = 'Công cộng (Mọi người có thể thấy)';
        $this->contents['LANG_EVENT_LABEL'] = 'Nhãn sự kiện';
        $this->contents['LANG_SEND_EMAIL_REMINDER'] = 'Gửi lời nhắc qua email';
        $this->contents['LANG_RECURRING_EVERY'] = 'Định kỳ mỗi';
        $this->contents['LANG_END_TIME'] = 'Thời gian kết thúc';
        $this->contents['LANG_START_TIME'] = 'Thời gian bắt đầu';
        $this->contents['LANG_WHOLE_DAY_EVENT'] = 'Sự kiện cả ngày';
        $this->contents['LANG_END_DATE'] = 'Ngày cuối';
        $this->contents['LANG_START_DATE'] = 'Ngày bắt đầu';
        $this->contents['LANG_EVENT_DESCRIPTION'] = 'Mô tả sự kiện';
        $this->contents['LANG_DAILY_MEETING'] = 'Cuộc họp hàng ngày';
        $this->contents['LANG_EVENT_TITLE'] = 'Tiêu đề sự kiện';
        $this->contents['LANG_MEETING_3PM'] = 'Họp lúc 3 giờ chiều';
    }
}
?>