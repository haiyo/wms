<?php
namespace Markaxis\Expense;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ExpenseRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ExpenseRes extends Resource {


    // Properties


    /**
     * ExpenseRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_EXPENSES_CLAIM'] = 'Yêu cầu bồi thường chi phí';
        $this->contents['LANG_CREATE_NEW_CLAIM'] = 'Tạo xác nhận quyền sở hữu mới';
        $this->contents['LANG_CREATE_NEW_EXPENSE_TYPE'] = 'Tạo loại chi phí mới';
        $this->contents['LANG_INVALID_CLAIM_TYPE'] = 'Loại xác nhận quyền sở hữu không hợp lệ';
        $this->contents['LANG_INVALID_CURRENCY'] = 'Tiền tệ không hợp lệ';
        $this->contents['LANG_PENDING_ROW_GROUP'] = 'Yêu cầu xác nhận quyền sở hữu';
        $this->contents['LANG_MAX_AMOUNT_CLAIMABLE'] = 'Số tiền tối đa có thể yêu cầu: {maxAmount}';
        $this->contents['LANG_AMOUNT_OVER_MAX'] = 'Số tiền yêu cầu của bạn vượt quá giới hạn tối đa là {maxAmount}.';
        $this->contents['LANG_CLAIM_PENDING_APPROVAL'] = '<?TPLVAR_FNAME?> <?TPLVAR_LNAME?> yêu cầu laim đang chờ bạn phê duyệt';

        $this->contents['LANG_CLAIM_TYPE'] = 'Loại yêu cầu';
        $this->contents['LANG_DESCRIPTION'] = 'Sự miêu tả';
        $this->contents['LANG_AMOUNT'] = 'Số tiền';
        $this->contents['LANG_ATTACHMENT'] = 'Tập tin đính kèm';
        $this->contents['LANG_STATUS'] = 'Trạng thái';
        $this->contents['LANG_MANAGERS'] = 'Giám đốc';
        $this->contents['LANG_DATE_CREATED'] = 'Ngày tạo';
        $this->contents['LANG_ACTIONS'] = 'Hành động';
        $this->contents['LANG_SELECT_EXPENSE_TYPE'] = 'Chọn loại chi phí';
        $this->contents['LANG_ENTER_DESCRIPTION_CLAIM'] = 'Nhập mô tả cho yêu cầu này';
        $this->contents['LANG_AMOUNT_TO_CLAIM'] = 'Số tiền Yêu cầu';
        $this->contents['LANG_ENTER_CLAIM_AMOUNT'] = 'Nhập số tiền yêu cầu';
        $this->contents['LANG_UPLOAD_SUPPORTING_DOCUMENT'] = 'Tải lên Tài liệu Hỗ trợ (Nếu có)';
        $this->contents['LANG_ACCEPTED_FORMATS'] = 'Các định dạng được chấp nhận: pdf, doc. Kích thước tệp tối đa';
        $this->contents['LANG_APPROVING_MANAGERS'] = 'Người quản lý phê duyệt';
        $this->contents['LANG_ENTER_MANAGER_NAME'] = 'Nhập tên người quản lý';
        $this->contents['LANG_CANCEL'] = 'Huỷ bỏ';
        $this->contents['LANG_SUBMIT'] = 'Gửi đi';
        $this->contents['LANG_EXPENSE_ITEM_TITLE'] = 'Tiêu đề khoản chi phí';
        $this->contents['LANG_MAX_AMOUT'] = 'Số tiền tối đa';
        $this->contents['LANG_ACTIONS'] = 'Hành động';
        $this->contents['LANG_EXPENSE_TYPE'] = 'Loại phí';
        $this->contents['LANG_ENTER_EXPENSE_TYPE'] = 'Nhập tiêu đề cho loại chi phí này';
        $this->contents['LANG_MAX_ALLOWED_CLAIM'] = 'Số tiền tối đa được phép yêu cầu';
        $this->contents['LANG_ENTER_AMOUNT'] = 'Nhập số tiền (Nhập 0 để không giới hạn)';
    }
}
?>