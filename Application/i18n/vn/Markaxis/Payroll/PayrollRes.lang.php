<?php
namespace Markaxis\Payroll;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PayrollRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollRes extends Resource {


    // Properties


    /**
     * PayrollRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_PAYROLL_CLAIM'] = 'Bảng lương và Yêu cầu';
        $this->contents['LANG_CPF_SUBMISSION'] = 'CPF Submission';
        $this->contents['LANG_TAX_FILING'] = 'Tax Filing (IRAS)';
        $this->contents['LANG_VIEW_DOWNLOAD_PAYSLIPS'] = 'Xem Payslips của tôi';
        $this->contents['LANG_PAYROLL_OVERVIEW'] = 'Tổng quan về Bảng lương';
        $this->contents['LANG_PAYROLL_ARCHIVE'] = 'Thêm kho lưu trữ bảng lương';
        $this->contents['LANG_PROCESS_PAYROLL'] = 'Xử lý bảng lương';
        $this->contents['LANG_CREATE_NEW_PAY_RUN'] = 'Tạo chi phí chạy mới';
        $this->contents['LANG_PAYSLIP_RECORDS'] = 'Bản ghi Payslip';
        $this->contents['LANG_PAYROLL_SETTINGS'] = 'Cài đặt bảng lương';
        $this->contents['LANG_ADD_PAY_CALENDAR'] = 'Thêm lịch trả tiền';
        $this->contents['LANG_WHICH_OFFICE'] = 'Văn phòng nào';
        $this->contents['LANG_SELECT_OFFICE'] = 'Chọn văn phòng';
        $this->contents['LANG_CREATE_NEW_PAY_ITEM'] = 'Tạo khoản thanh toán mới';
        $this->contents['LANG_CREATE_NEW_PAY_CALENDAR'] = 'Tạo lịch trả tiền mới';
        $this->contents['LANG_STARTDATE_HELP'] = 'Kỳ trả lương này kết thúc vào {endDate} và lặp lại {payPeriod}';
        $this->contents['LANG_FIRST_PAYMENT_HELP'] = 'Ngày thanh toán sắp tới: {dates}';
        $this->contents['LANG_MY_PAYSLIPS'] = 'Payslips của tôi';
        $this->contents['LANG_UPCOMING'] = 'Sắp tới';
        $this->contents['LANG_COMPLETED'] = 'Đã hoàn thành';
        $this->contents['LANG_NO_DATA'] = 'Không có dữ liệu';
        $this->contents['LANG_VERIFICATION_FAILED'] = 'Xác minh không hoàn thành';
        $this->contents['LANG_NOT_PROCESS_YET'] = 'bảng lương vẫn chưa được xử lý.<br />Bạn có muốn xử lý nó ngay bây giờ không?';
        $this->contents['LANG_LETS_DO_IT'] = 'Vâng chúng ta hãy làm điều đó!';
        $this->contents['LANG_ENTER_PASSWORD'] = 'Vui lòng nhập mật khẩu của bạn để tiếp tục';
        $this->contents['LANG_CREATE_NEW_TAX_FILING'] = 'Tạo hồ sơ thuế mới';
        $this->contents['LANG_CREATE_AMENDMENT'] = 'Tạo bản sửa đổi';
        $this->contents['LANG_WHAT_IS_AIS'] = 'WHAT IS AUTO-INCLUSION SCHEME(AIS)?';
        $this->contents['LANG_IRAS_FORM'] = 'IRAS Form';
        $this->contents['LANG_SELECT_EMPLOYEE'] = 'Chọn nhân viên';
        $this->contents['LANG_DECLARATION_FOR_INDIVIDUAL_EMPLOYEE'] = 'Tuyên bố cho nhân viên cá nhân (Không bắt buộc)';
        $this->contents['LANG_FILE_TAX_FOR_YEAR'] = 'Khai thuế cho năm';
        $this->contents['LANG_SELECT_OFFICE'] = 'Chọn văn phòng';
        $this->contents['LANG_AUTHORIZED_SUBMITTING_PERSONNEL'] = 'Nhân viên đệ trình được ủy quyền';
        $this->contents['LANG_FIRST_NAME_LAST_NAME'] = 'Tên và họ';
        $this->contents['LANG_DESIGNATION'] = 'Chỉ định';
        $this->contents['LANG_IDENTITY_TYPE'] = 'Loại nhận dạng';
        $this->contents['LANG_IDENTITY_NUMBER'] = 'Số nhận dạng';
        $this->contents['LANG_EMAIL'] = 'Địa chỉ email';
        $this->contents['LANG_CONTACT_NUMBER'] = 'Số liên lạc';
        $this->contents['LANG_TOTAL_EMPLOYER_LEVY'] = 'Tổng mức thu của nhà tuyển dụng';
        $this->contents['LANG_TOTAL_EMPLOYER_CONTRIBUTION'] = 'Tổng số đóng góp của người sử dụng lao động';
        $this->contents['LANG_TOTAL_CLAIM'] = 'Tổng yêu cầu';
        $this->contents['LANG_PAY_PERIOD'] = 'Thời gian thu phí';
        $this->contents['LANG_PAYMENT_METHOD'] = 'Phương thức thanh toán';
        $this->contents['LANG_BANK_NAME'] = 'Tên ngân hàng';
        $this->contents['LANG_ACCOUNT_NUMBER'] = 'Số tài khoản';
        $this->contents['LANG_PAYSLIP'] = 'Payslip';
        $this->contents['LANG_NAME'] = 'Tên';
        $this->contents['LANG_NEXT_PAYMENT_DATE'] = 'Ngày thanh toán tiếp theo';
        $this->contents['LANG_PAYMENT_CYCLE'] = 'Chu kỳ thanh toán';
        $this->contents['LANG_ACTIONS'] = 'Hành động';
        $this->contents['LANG_HOW_OFTEN_PAY'] = 'Bạn sẽ trả cho nhân viên của mình bao lâu một lần?';
        $this->contents['LANG_PAY_RUN_TITLE'] = 'Pay Run Title';
        $this->contents['LANG_MONTHLY_WEEKLY'] = 'Nhân viên toàn thời gian hàng tháng';
        $this->contents['LANG_PAYMENT_CYCLE_DATE'] = 'Ngày chu kỳ thanh toán';
        $this->contents['LANG_PAY_CALENDAR'] = 'Lịch trả tiền';
        $this->contents['LANG_PAY_ITEMS'] = 'Thanh toán các mặt hàng';
        $this->contents['LANG_EXPENSES_ITEM'] = 'Khoản mục Chi phí';
        $this->contents['LANG_TAX_RULES'] = 'Quy tắc thuế';
        $this->contents['LANG_PAY_ITEM_TITLE'] = 'Trả tiêu đề mặt hàng';
        $this->contents['LANG_BASIC'] = 'Căn bản';
        $this->contents['LANG_ORDINARY'] = 'Bình thường';
        $this->contents['LANG_DEDUCTION'] = 'Khấu trừ';
        $this->contents['LANG_DEDUCTION_AW'] = 'Khấu trừ AW';
        $this->contents['LANG_ADDITIONAL'] = 'Bổ sung';
        $this->contents['LANG_ENTER_PAY_ITEM_TITLE'] = 'Nhập tiêu đề cho mặt hàng trả tiền này';
        $this->contents['LANG_FORMULA'] = 'Công thức';
        $this->contents['LANG_ENTER_FORMULA'] = 'Nhập công thức (tùy chọn)';
        $this->contents['LANG_PAY_ITEM_BELONGS_TO'] = 'Khoản mục phải trả này thuộc về';
        $this->contents['LANG_NONE'] = 'Không ai';
        $this->contents['LANG_CREATE_NEW_TAX_GROUP'] = 'Tạo nhóm thuế mới';
        $this->contents['LANG_CREATE_NEW_TAX_RULE'] = 'Tạo quy tắc thuế mới';
        $this->contents['LANG_NO_TAX'] = 'Không thuế';
        $this->contents['LANG_TAX_GROUP_TITLE'] = 'Tên nhóm thuế';
        $this->contents['LANG_ENTER_TAX_GROUP_TITLE'] = 'Nhập tiêu đề cho nhóm này';
        $this->contents['LANG_OFFICE'] = 'Văn phòng';
        $this->contents['LANG_DESCRIPTION'] = 'Sự miêu tả';
        $this->contents['LANG_ENTER_TAX_GROUP_DESCRIPTION'] = 'Mô tả cho nhóm này (Tùy chọn)';
        $this->contents['LANG_PARENT'] = 'Cha mẹ';
        $this->contents['LANG_ALLOW_SELECTION'] = 'Cho phép lựa chọn khi tạo / chỉnh sửa nhân viên';
        $this->contents['LANG_DISPLAY_SUMMARY'] = 'Hiển thị trên Tóm tắt Bảng lương';
        $this->contents['LANG_TAX_RULE_TITLE'] = 'Tiêu đề quy tắc thuế';
        $this->contents['LANG_ENTER_TAX_RULE_TITLE'] = 'Nhập tiêu đề cho quy tắc thuế này';
        $this->contents['LANG_APPLY_WHICH_COUNTRY'] = 'Áp dụng cho quốc gia nào';
        $this->contents['LANG_BELONG_TO_GROUP'] = 'Thuộc nhóm';
        $this->contents['LANG_SELECT_CRITERIA'] = 'Chọn tiêu chí';
        $this->contents['LANG_COMPUTING_VARIABLE'] = 'Tính toán các biến';
        $this->contents['LANG_AGE'] = 'Tuổi tác';
        $this->contents['LANG_PAY_ITEM'] = 'Khoản thanh toán';
        $this->contents['LANG_ALL_PAY_ITEM'] = 'Tất cả các khoản thanh toán';
        $this->contents['LANG_TOTAL_WORKFORCE'] = 'Tổng lực lượng lao động';
        $this->contents['LANG_OTHER_EMPLOYEE_VARIABLES'] = 'Các biến nhân viên khác';
        $this->contents['LANG_COMPETENCY'] = 'Năng lực';
        $this->contents['LANG_CONTRACT_TYPE'] = 'Thể loại hợp đồng';
        $this->contents['LANG_RACE'] = 'Cuộc đua';
        $this->contents['LANG_GENDER'] = 'Giới tính';
        $this->contents['LANG_COMPUTING'] = 'Tin học';
        $this->contents['LANG_LESS_THAN'] = 'Ít hơn';
        $this->contents['LANG_GREATER_THAN'] = 'Lớn hơn';
        $this->contents['LANG_LESS_THAN_OR_EQUAL'] = 'Nhỏ hơn hoặc bằng';
        $this->contents['LANG_LESS_THAN_OR_EQUAL_AND_CAPPED'] = 'Ít hơn hoặc bằng và giới hạn ở';
        $this->contents['LANG_GREATER_THAN_OR_EQUAL'] = 'Lớn hơn hoặc bằng';
        $this->contents['LANG_EQUAL'] = 'Công bằng';
        $this->contents['LANG_AMOUNT_TYPE'] = 'Loại số tiền';
        $this->contents['LANG_PERCENTAGE'] = 'Phần trăm';
        $this->contents['LANG_FIXED_INTEGER'] = 'Cố định / Số nguyên';
        $this->contents['LANG_VALUE'] = 'Giá trị';
        $this->contents['LANG_SELECT_PAY_ITEM'] = 'Chọn mục thanh toán';
        $this->contents['LANG_CUSTOM_FORMULA'] = 'Công thức tùy chỉnh';
        $this->contents['LANG_ENTER_COMPETENCIES'] = 'Nhập năng lực';
        $this->contents['LANG_TYPE_ENTER_NEW_COMPETENCY'] = 'Nhập và nhấn Enter để thêm năng lực mới';
        $this->contents['LANG_ENTER_SKILLSETS_OR_KNOWLEDGE'] = 'Nhập các bộ kỹ năng hoặc kiến thức';
        $this->contents['LANG_SELECT_CONTRACT_TYPE'] = 'Chọn loại hợp đồng';
        $this->contents['LANG_SELECT_DESIGNATION'] = 'Chọn chỉ định';
        $this->contents['LANG_SELECT_RACE'] = 'Chọn cuộc đua';
        $this->contents['LANG_SELECT_GENDER'] = 'Chọn giới tính';
        $this->contents['LANG_APPLY_ABOVE_CRITERIA_AS'] = 'Áp dụng các tiêu chí trên như';
        $this->contents['LANG_DEDUCTION_FROM_ORDINARY'] = 'Khấu trừ tiền lương bình thường';
        $this->contents['LANG_DEDUCTION_FROM_ADDITIONAL'] = 'Khấu trừ tiền lương bổ sung';
        $this->contents['LANG_EMPLOYER_CONTRIBUTION'] = 'Đóng góp của chủ lao động';
        $this->contents['LANG_SKILL_DEVELOPMENT_LEVY'] = 'Levy phát triển kỹ năng';
        $this->contents['LANG_FOREIGN_WORKER_LEVY'] = 'Levy công nhân nước ngoài';
        $this->contents['LANG_TYPE_OF_VALUE'] = 'Loại giá trị';
        $this->contents['LANG_CAPPED_AMOUNT_FORMULA'] = 'Giới hạn (Số lượng / Công thức)';
        $this->contents['LANG_TOTAL_GROSS'] = 'Tổng doanh thu';
        $this->contents['LANG_TOTAL_NET_PAYABLE'] = 'Tổng phải trả ròng';
        $this->contents['LANG_PAYMENT'] = 'Thanh toán';
        $this->contents['LANG_PROCESS_PERIOD'] = 'Thời gian quy trình';
        $this->contents['LANG_SELECT_EMPLOYEE_TO_PROCESS'] = 'Chọn nhân viên để xử lý bảng lương';
        $this->contents['LANG_EMPLOYEE_ID'] = 'Số nhân viên';
        $this->contents['LANG_EMPLOYEE'] = 'Nhân viên';
        $this->contents['LANG_EMPLOYMENT_STATUS'] = 'Tình trạng việc làm';
        $this->contents['LANG_SUMMARY'] = 'Tóm lược';
        $this->contents['LANG_GROSS'] = 'Tổng';
        $this->contents['LANG_CLAIM'] = 'Yêu cầu';
        $this->contents['LANG_LEVY'] = 'Levy';
        $this->contents['LANG_CONTRIBUTION'] = 'Sự đóng góp';
        $this->contents['LANG_NET'] = 'Thanh toán ròng';
        $this->contents['LANG_TOTAL'] = 'Toàn bộ';
        $this->contents['LANG_ACCOUNT_PAYSLIP_RELEASE'] = 'Phát hành tài khoản và phiếu thanh toán';
        $this->contents['LANG_ACCOUNT_DETAILS'] = 'Chi tiết tài khoản';
        $this->contents['LANG_PAYABLE'] = 'Phải trả';
        $this->contents['LANG_RELEASED'] = 'Phát hành';
        $this->contents['LANG_PAYMENT_METHOD'] = 'Phương thức thanh toán';
        $this->contents['LANG_ITEM_TYPE'] = 'Loại sản phẩm';
        $this->contents['LANG_AMOUNT'] = 'Số tiền';
        $this->contents['LANG_REMARK'] = 'Nhận xét';
        $this->contents['LANG_CONFIRMATION_DATE'] = 'Ngày xác nhận';
        $this->contents['LANG_DATE_TYPE'] = 'Loại ngày';
        $this->contents['LANG_CURRENT'] = 'Ngay hiện tại';
        $this->contents['LANG_ACCOUNT_AND_PAYSLIP'] = 'Tài khoản và Phiếu thanh toán';
        $this->contents['LANG_RELEASE_PAYSLIPS'] = 'Phát hành Payslips';
        $this->contents['LANG_RELEASE_ALL_PAYSLIPS'] = 'Phát hành tất cả các Payslips';
        $this->contents['LANG_COMPLETE_PROCESS'] = 'Hoàn thành quy trình';
        $this->contents['LANG_CONFIRM_FINALIZE'] = 'Xác nhận và hoàn thiện';
        $this->contents['LANG_PAYROLL_SAVED'] = 'Payroll Saved';
        $this->contents['LANG_PAYROLL_SAVED_DESCRIPT'] = 'Lưu ý: Bảng lương này không được hoàn thiện cho đến khi được xác nhận và quyết toán. Bạn vẫn có thể xử lý lại bảng lương bất cứ lúc nào';
        $this->contents['LANG_REPROCESS_CONFIRMATION'] = 'Bạn có chắc chắn muốn xử lý lại không {username}\'s lương bổng?';
        $this->contents['LANG_REPROCESS_CONFIRMATION_DESCRIPT'] = 'Không thể hoàn tác hành động này và tất cả các loại mặt hàng sẽ được đặt lại!';
        $this->contents['LANG_CONFIRM_REPROCESS'] = 'Xác nhận Xử lý lại';
        $this->contents['LANG_FINALIZE_CONFIRM'] = 'Bạn có chắc mọi thứ đã hoàn thành không?';
        $this->contents['LANG_FINALIZE_CONFIRM_DESCRIPT'] = 'Sau khi xác nhận, sẽ không có thay đổi nào được thực hiện';

        $this->contents['LANG_WORK_DAYS'] = 'Ngày làm việc';
        $this->contents['LANG_AVG_SALARY'] = 'Lương trung bình';
        $this->contents['LANG_AVG_CONTRIBUTIONS'] = 'Đóng góp trung bình';
        $this->contents['LANG_SALARIES_PAID'] = 'BÁN HÀNG ĐÃ TRẢ';
        $this->contents['LANG_CLAIMS_PAID'] = 'YÊU CẦU ĐÃ TRẢ';
        $this->contents['LANG_LEVIES_PAID'] = 'LEVIES ĐÃ TRẢ';
        $this->contents['LANG_VIEW_FINALIZED_PAYROLL'] = 'Xem hoàn thiện';
        $this->contents['LANG_VERIFY_CREDENTIAL'] = 'Xác minh thông tin đăng nhập';
        $this->contents['LANG_ENTER_PASSWORD_CONTINUE'] = 'Nhập mật khẩu của bạn để tiếp tục';
        $this->contents['LANG_UNLOCK'] = 'Mở khóa';

        $this->contents['LANG_EDIT_PAY_CAL'] = 'Chỉnh sửa lịch trả tiền';
        $this->contents['LANG_PLEASE_ENTER_TITLE'] = 'Vui lòng nhập Tiêu đề Chạy trả tiền cho giai đoạn này';
        $this->contents['LANG_PLEASE_SELECT_PERIOD'] = 'Vui lòng chọn Kỳ thanh toán';
        $this->contents['LANG_PLEASE_SELECT_DATE'] = 'Vui lòng chọn Ngày thanh toán tiếp theo';
        $this->contents['LANG_PAY_CAL_CREATED_SUCCESSFULLY'] = 'Lịch thanh toán đã được tạo thành công';
        $this->contents['LANG_PAY_CAL_CREATED_SUCCESSFULLY_DESCRIPT'] = 'Lịch thanh toán của bạn đã được tạo thành công';
        $this->contents['LANG_PAY_CAL_UPDATED_SUCCESSFULLY'] = 'Đã cập nhật lịch thanh toán thành công';
        $this->contents['LANG_PAY_CAL_UPDATED_SUCCESSFULLY_DESCRIPT'] = 'Lịch thanh toán của bạn đã được cập nhật thành công';
        $this->contents['LANG_DELETE_PAY_CAL'] = 'Xóa lịch thanh toán';
        $this->contents['LANG_SEARCH_PAY_CAL'] = 'Tìm kiếm Lịch trả tiền';

        $this->contents['LANG_EDIT_PAY_ITEM'] = 'Chỉnh sửa khoản thanh toán';
        $this->contents['LANG_PLEASE_ENTER_PAY_ITEM_TITLE'] = 'Vui lòng nhập Tiêu đề mặt hàng thanh toán';
        $this->contents['LANG_CREATE_ANOTHER_PAY_ITEM'] = 'Tạo một khoản thanh toán khác';
        $this->contents['LANG_NO_PAY_ITEM_SELECTED'] = 'Không có khoản thanh toán nào được chọn';
        $this->contents['LANG_DELETE_SELECTED_PAY_ITEMS'] = 'Bạn có chắc chắn muốn xóa các Khoản phải trả đã chọn không?';
        $this->contents['LANG_DELETE_PAY_ITEM'] = 'Xóa khoản thanh toán';
        $this->contents['LANG_SEARCH_PAY_ITEM'] = 'Tìm kiếm mặt hàng trả tiền';

        $this->contents['LANG_REPROCESS_PAYROLL'] = 'Xử lý lại bảng lương';
        $this->contents['LANG_SAVE_PAYROLL'] = 'Lưu bảng lương';
        $this->contents['LANG_SAVED'] = 'Đã lưu';
        $this->contents['LANG_SUSPENDED'] = 'Đình chỉ';
        $this->contents['LANG_RESIGNED'] = 'Đã từ chức';
        $this->contents['LANG_EXPIRED_SOON'] = 'Sắp hết hạn';
        $this->contents['LANG_ACTIVE'] = 'Hoạt động';
        $this->contents['LANG_PROCESS'] = 'Quá trình';
        $this->contents['LANG_SEARCH_EMPLOYEE'] = 'Tìm kiếm nhân viên, chức vụ hoặc loại hợp đồng';

        $this->contents['LANG_NO_EMPLOYEE_SELECTED'] = 'Không có nhân viên nào được chọn';
        $this->contents['LANG_CONFIRM_RELEASE_PAYSLIP'] = 'Xác nhận phát hành phiếu lương của nhân viên {count}?';
        $this->contents['LANG_SELECTED_EMPLOYEE_EMAIL'] = 'Nhân viên được chọn sẽ nhận được thông báo qua email để xem phiếu lương của họ sau khi được xác nhận';
        $this->contents['LANG_CONFIRM_RELEASE'] = 'Xác nhận phát hành';
        $this->contents['LANG_PAYSLIP_SUCCESSFULLY_RELEASED'] = '{count} phiếu lương của nhân viên đã được phát hành thành công!';
        $this->contents['LANG_CONFIRM_RELEASE_ALL_PAYSLIP'] = 'Xác nhận phát hành tất cả phiếu lương của nhân viên?';
        $this->contents['LANG_ALL_EMPLOYEE_EMAIL'] = 'Tất cả nhân viên sẽ nhận được thông báo qua email để xem phiếu lương của họ sau khi xác nhận';
        $this->contents['LANG_CONFIRM_RELEASE_ALL'] = 'Xác nhận phát hành tất cả';
        $this->contents['LANG_ALL_PAYSLIP_SUCCESSFULLY_RELEASED'] = 'Tất cả phiếu lương của nhân viên đã được phát hành thành công!';
        $this->contents['LANG_VIEW_PDF'] = 'Xem PDF';
        $this->contents['LANG_SEARCH_EMPLOYEE_NAME'] = 'Tìm kiếm tên nhân viên';

        $this->contents['LANG_TOTAL_SALARIES'] = 'Tổng lương';
        $this->contents['LANG_TOTAL_CLAIMS'] = 'Tổng số xác nhận quyền sở hữu';
        $this->contents['LANG_TOTAL_LEVIES'] = 'Tổng số Levies';
        $this->contents['LANG_CONTRIBUTIONS'] = 'Tổng số đóng góp';

        $this->contents['LANG_COMPANY_REG_NO'] = 'Số đăng ký công ty';
        $this->contents['LANG_DEPARTMENT'] = 'Phòng ban';
        $this->contents['LANG_EMPLOYER_NAME'] = 'Tên nhà tuyển dụng';
        $this->contents['LANG_JOIN_DATE'] = 'Ngày tham gia';
    }
}
?>