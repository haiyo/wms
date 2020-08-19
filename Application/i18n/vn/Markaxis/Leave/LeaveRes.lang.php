<?php
namespace Markaxis\Leave;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LeaveRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveRes extends Resource {


    // Properties


    /**
     * LeaveRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_LEAVE_EVENTS'] = 'Rời khỏi và sự kiện';
        $this->contents['LANG_TODAY'] = 'Hôm nay';
        $this->contents['LANG_TOMORROW'] = 'Ngày mai';
        $this->contents['LANG_WHOS_ON_LEAVE'] = 'Ai đang nghỉ';
        $this->contents['LANG_NO_ONE_ON_LEAVE_TODAY'] = 'Hôm nay không có ai nghỉ';
        $this->contents['LANG_NO_ONE_ON_LEAVE_TOMORROW'] = 'Không ai được nghỉ vào ngày mai';
        $this->contents['LANG_ITS_HOLIDAY'] = 'Nó là một kì nghỉ!';
        $this->contents['LANG_LEAVE_BALANCE_STATUS'] = 'Để lại số dư và trạng thái';
        $this->contents['LANG_LEAVE_BALANCE'] = 'Trung bình còn lại';
        $this->contents['LANG_LEAVE_SETTINGS'] = 'Rời khỏi Cài đặt';
        $this->contents['LANG_CREATE_NEW_LEAVE_TYPE'] = 'Tạo loại rời mới';
        $this->contents['LANG_LEAVE_OVERVIEW'] = 'Rời khỏi Tổng quan';
        $this->contents['LANG_APPLY_LEAVE_STATUS'] = 'Đăng ký nghỉ / Trạng thái';
        $this->contents['LANG_PRO_RATED'] = 'Pro-Xếp hạng';
        $this->contents['LANG_NOT_PRO_RATED'] = 'Không được xếp hạng';
        $this->contents['LANG_ALLOW_HALF_DAY'] = 'Cho phép nửa ngày';
        $this->contents['LANG_NO_HALF_DAY'] = 'Không nửa ngày';
        $this->contents['LANG_PAID_LEAVE'] = 'Nghỉ có lương';
        $this->contents['LANG_UNPAID_LEAVE'] = 'Nghỉ phép không lương';
        $this->contents['LANG_UPON_HIRED'] = 'Khi được thuê';
        $this->contents['LANG_AFTER_PROBATION_PERIOD'] = 'Sau thời gian thử việc';
        $this->contents['LANG_EMPLOYEE_CONFIRMATION_DATE'] = 'Ngày xác nhận nhân viên';
        $this->contents['LANG_FORFEITED'] = 'Bị tịch thu vào cuối kỳ';
        $this->contents['LANG_CARRIED_OVER'] = 'Có thể chuyển sang tiết sau';
        $this->contents['LANG_MONTHS'] = 'Tháng';
        $this->contents['LANG_WEEKS'] = 'Tuần';
        $this->contents['LANG_DAYS'] = 'Ngày';
        $this->contents['LANG_APPROVED'] = 'Tán thành';
        $this->contents['LANG_UNAPPROVED'] = 'Không được chấp thuận';
        $this->contents['LANG_PENDING'] = 'Đang chờ xử lý';
        $this->contents['LANG_%_ENTITLEMENT'] = '% Quyền lợi';
        $this->contents['LANG_SELECT_PERIOD'] = 'Chọn khoảng thời gian';
        $this->contents['LANG_LEAVE_ENTITLEMENT'] = 'Quyền rời bỏ';
        $this->contents['LANG_LEAVE_TYPE_NAME'] = 'Để lại tên loại';
        $this->contents['LANG_LEAVE_TYPE_PLACEHOLDER'] = 'Nghỉ phép năm, Nghỉ ốm, Nghỉ chăm sóc con cái';
        $this->contents['LANG_LEAVE_CODE'] = 'Để lại mã';
        $this->contents['LANG_LEAVE_CODE_PLACEHOLDER'] = 'AL, SL, CCL, etc';
        $this->contents['LANG_LEAVE_CAN_BE_APPLIED'] = 'Nghỉ phép có thể được áp dụng';
        $this->contents['LANG_PROBATION_PERIOD'] = 'Thời gian thử việc';
        $this->contents['LANG_MONTHLY_BASIS'] = 'Hàng tháng';
        $this->contents['LANG_IS_THIS_PRO_RATED'] = 'Chia theo tỷ lệ?';
        $this->contents['LANG_IS_CHILD_CARE_LEAVE'] = 'Có được nghỉ việc chăm sóc trẻ em không?';
        $this->contents['LANG_UNUSED_LIST'] = 'Nghỉ phép không sử dụng';
        $this->contents['LANG_CARRY_OVER_LIMIT'] = 'Vượt quá giới hạn';
        $this->contents['LANG_TO_BE_USED_WITHIN'] = 'Được sử dụng hết trong';
        $this->contents['LANG_PAYROLL_PROCESS_AS'] = 'Quy trình trả lương như';
        $this->contents['LANG_PAYROLL_FORMULA_FOR_UNPAID_LEAVE'] = 'Công thức tính lương cho nghỉ việc không trả tiền';
        $this->contents['LANG_SHOW_CHART_LEAVE_BALANCE'] = 'Hiển thị Biểu đồ trong Số dư Để lại';
        $this->contents['LANG_GENDER'] = 'Giới tính';
        $this->contents['LANG_DESIGNATION'] = 'Chỉ định';
        $this->contents['LANG_CONTRACT_TYPE'] = 'Thể loại hợp đồng';
        $this->contents['LANG_COUNTRY'] = 'Quốc gia';
        $this->contents['LANG_NATIONALITY'] = 'Quốc tịch';
        $this->contents['LANG_MARITAL_STATUS'] = 'Tình trạng hôn nhân';
        $this->contents['LANG_MUST_HAVE_CHILDREN'] = 'Phải có con';
        $this->contents['LANG_CHILD_BORN_IN'] = 'Đứa trẻ sinh ra trong';
        $this->contents['LANG_CHILD_NOT_BORN_IN'] = 'Đứa trẻ không được sinh ra trong';
        $this->contents['LANG_CHILD_MAX_AGE'] = 'Tuổi tối đa của trẻ em';
        $this->contents['LANG_ENTITLEMENT_STRUCTURE'] = 'Cơ cấu quyền lợi';
        $this->contents['LANG_LEAVE_STRUCTURE_HEADER'] = 'Xác định cơ cấu quyền lợi nghỉ phép dựa trên số tháng đã hoàn thành dịch vụ của Nhân viên';
        $this->contents['LANG_SELECT_DESIGNATION_HEADER'] = 'Chọn loại Chỉ định bạn muốn chỉ định cho Nhóm Rời khỏi này';
        $this->contents['LANG_EMPLOYEE_START_MONTH'] = 'Tháng bắt đầu của nhân viên';
        $this->contents['LANG_EMPLOYEE_END_MONTH'] = 'Nhân viên cuối tháng';
        $this->contents['LANG_ELIGIBLE_DAYS_LEAVES'] = 'Ngày đủ điều kiện của lá';
        $this->contents['LANG_OFFICE_LOCATION'] = 'Địa điểm văn phòng';
        $this->contents['LANG_FULL_DAY'] = 'Cả ngày';
        $this->contents['LANG_HALF_DAY'] = 'Nửa ngày';
        $this->contents['LANG_INVALID_BALANCE'] = 'Số dư để lại không hợp lệ';
        $this->contents['LANG_INVALID_DATE_RANGE'] = 'Vui lòng chọn một phạm vi ngày hợp lệ cho đơn xin nghỉ việc của bạn';
        $this->contents['LANG_APPLYING'] = 'Bạn đang áp dụng {days} nghỉ phép (Không bao gồm các ngày cuối tuần và ngày lễ)';
        $this->contents['LANG_APPLY_DAYS'] = '{n} ngày|ngày';
        $this->contents['LANG_APPLY_HOURS'] = '{n} giờ|giờ';
        $this->contents['LANG_HALF_DAY_NOT_ALLOWED'] = 'Bạn không thể áp dụng nửa ngày cho loại nghỉ phép này';
        $this->contents['LANG_CHOOSE_LEAVE_TYPE'] = 'Vui lòng chọn kiểu rời';
        $this->contents['LANG_INSUFFICIENT_LEAVE'] = 'Bạn không có đủ thời gian nghỉ cho yêu cầu này';
        $this->contents['LANG_PENDING_ROW_GROUP'] = 'Yêu cầu rời khỏi';
        $this->contents['LANG_FROM'] = 'Từ';
        $this->contents['LANG_TO'] = 'Đến';
        $this->contents['LANG_CREATE_CUSTOM_HOLIDAY'] = 'Tạo ngày lễ tùy chỉnh';
        $this->contents['LANG_PROVIDE_ALL_REQUIRED_FIELDS'] = 'Vui lòng cung cấp tất cả các trường bắt buộc';
    }
}
?>