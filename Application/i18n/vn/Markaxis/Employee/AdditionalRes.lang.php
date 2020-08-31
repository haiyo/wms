<?php
namespace Markaxis\Employee;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: EmployeeRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AdditionalRes extends Resource {


    // Properties


    /**
     * EmployeeRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_ADDITIONAL_INFO'] = 'thông tin thêm';
        $this->contents['LANG_ECONTACT_INFO'] = 'Nếu có bất kỳ trẻ em nào, hãy nhớ thêm họ vào địa chỉ liên hệ vì mục đích Nghỉ phép';
        $this->contents['LANG_SELECT_TAX_GROUP'] = 'Chọn nhóm thuế';
        $this->contents['LANG_SELECT_PAYROLL_CALENDAR'] = 'Chọn Lịch trả lương';
        $this->contents['LANG_SELECT_PAYMENT_METHOD'] = 'Chọn phương thức thanh toán';
        $this->contents['LANG_SELECT_BANK'] = 'Chọn ngân hàng';
        $this->contents['LANG_SELECT_LEAVE_TYPE'] = 'Chọn Loại rời';
        $this->contents['LANG_FINANCE_LEAVE'] = 'Tài chính và Nghỉ phép';
        $this->contents['LANG_ASSIGN_PAYROLL_CALENDAR'] = 'Chỉ định lịch trả lương';
        $this->contents['LANG_ASSIGN_TAX_GROUP'] = 'Chỉ định nhóm thuế';
        $this->contents['LANG_ASSIGN_LEAVE_TYPE'] = 'Chỉ định loại nghỉ';
        $this->contents['LANG_EMPLOYEE_PAYMENT_DETAILS'] = 'Chi tiết thanh toán cho nhân viên';
        $this->contents['LANG_PAYMENT_METHOD'] = 'Phương thức thanh toán';
        $this->contents['LANG_BANK'] = 'Ngân hàng';
        $this->contents['LANG_BANK_ACCOUNT_NUMBER'] = 'Số tài khoản ngân hàng';
        $this->contents['LANG_BANK_CODE'] = 'Mã ngân hàng';
        $this->contents['LANG_BANK_BRANCH_CODE'] = 'Mã chi nhánh ngân hàng';
        $this->contents['LANG_BANK_ACCOUNT_NAME'] = 'Tên chủ tài khoản ngân hàng';
        $this->contents['LANG_BANK_SWIFT_CODE'] = 'Mã Swift của Ngân hàng';
    }
}
?>