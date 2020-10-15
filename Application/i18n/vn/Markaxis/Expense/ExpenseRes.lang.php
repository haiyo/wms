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
        $this->contents['LANG_INVALID_COUNTRY'] = 'Quốc gia không hợp lệ';
        $this->contents['LANG_PENDING_ROW_GROUP'] = 'Yêu cầu xác nhận quyền sở hữu';
        $this->contents['LANG_MAX_AMOUNT_CLAIMABLE'] = 'Số tiền tối đa có thể yêu cầu: {maxAmount}';
        $this->contents['LANG_AMOUNT_OVER_MAX'] = 'Số tiền yêu cầu của bạn vượt quá giới hạn tối đa là {maxAmount}.';
        $this->contents['LANG_CLAIM_PENDING_APPROVAL'] = '<?TPLVAR_FNAME?> <?TPLVAR_LNAME?> yêu cầu laim đang chờ bạn phê duyệt';

        $this->contents['LANG_CLAIM_TYPE'] = 'Loại yêu cầu';
        $this->contents['LANG_AMOUNT'] = 'Số tiền';
        $this->contents['LANG_ATTACHMENT'] = 'Tập tin đính kèm';
        $this->contents['LANG_STATUS'] = 'Trạng thái';
        $this->contents['LANG_MANAGERS'] = 'Giám đốc';
        $this->contents['LANG_DATE_CREATED'] = 'Ngày tạo';
        $this->contents['LANG_SELECT_EXPENSE_ITEM'] = 'Chọn loại chi phí';
        $this->contents['LANG_ENTER_DESCRIPTION_CLAIM'] = 'Nhập mô tả cho yêu cầu này';
        $this->contents['LANG_AMOUNT_TO_CLAIM'] = 'Số tiền Yêu cầu';
        $this->contents['LANG_ENTER_CLAIM_AMOUNT'] = 'Nhập số tiền yêu cầu';

        $this->contents['LANG_EXPENSE_ITEM_TITLE'] = 'Tiêu đề khoản chi phí';
        $this->contents['LANG_COUNTRY'] = 'Quốc gia';
        $this->contents['LANG_MAX_AMOUT'] = 'Số tiền tối đa';
        $this->contents['LANG_EXPENSE_TYPE'] = 'Loại phí';
        $this->contents['LANG_APPLY_COUNTRY'] = 'Áp dụng cho quốc gia nào';
        $this->contents['LANG_SELECT_COUNTRY'] = 'Chọn quốc gia';
        $this->contents['LANG_ENTER_TITLE_EXPENSE_TYPE'] = 'Nhập tiêu đề cho loại chi phí này';
        $this->contents['LANG_MAX_ALLOWED_CLAIM'] = 'Số tiền tối đa được phép yêu cầu';
        $this->contents['LANG_ENTER_AMOUNT'] = 'Nhập số tiền (Nhập 0 để không giới hạn)';
        $this->contents['LANG_EDIT_CLAIM'] = 'Chỉnh sửa yêu cầu';
        $this->contents['LANG_CREATE_NEW_CLAIM'] = 'Tạo mới yêu cầu';
        $this->contents['LANG_CONFIRM_CANCEL_CLAIM'] = 'Bạn có chắc chắn muốn hủy yêu cầu {title}?';
        $this->contents['LANG_CONFIRM_CANCEL_CLAIM_DESCRIPT'] = 'Không thể hoàn tác hành động này sau khi đã hủy';
        $this->contents['LANG_CLAIM_CANCELLED_SUCCESSFULLY'] = '{title} đã được hủy thành công!';
        $this->contents['LANG_CLAIM_SUCCESSFULLY_CREATED'] = 'Yêu cầu đã được tạo thành công!';
        $this->contents['LANG_CREATE_ANOTHER_CLAIM'] = 'Tạo ra một cái khác yêu cầu';
        $this->contents['LANG_PAID'] = 'Đã thanh toán';
        $this->contents['LANG_CANCEL_CLAIM'] = 'Huỷ bỏ yêu cầu';
        $this->contents['LANG_SEARCH_CLAIM'] = 'Tìm kiếm yêu cầu';

        $this->contents['LANG_EDIT_EXPENSE_TYPE'] = 'Chỉnh sửa Loại Chi phí';
        $this->contents['LANG_ENTER_EXPENSE_TYPE'] = 'Vui lòng nhập Tiêu đề Loại Chi phí';
        $this->contents['LANG_ENTER_MAX_AMOUNT'] = 'Vui lòng nhập số tiền tối đa';
        $this->contents['LANG_PLEASE_SELECT_COUNTRY'] = 'Vui lòng chọn quốc gia';
        $this->contents['LANG_EXPENSE_CREATED_SUCCESSFULLY'] = 'Đã tạo thành công loại chi phí';
        $this->contents['LANG_EXPENSE_CREATED_SUCCESSFULLY_DESCRIPT'] = 'Loại chi phí mới đã được tạo thành công';
        $this->contents['LANG_EXPENSE_UPDATED_SUCCESSFULLY'] = 'Đã cập nhật thành công loại chi phí';
        $this->contents['LANG_EXPENSE_UPDATED_SUCCESSFULLY_DESCRIPT'] = 'Loại chi phí đã được cập nhật thành công';
        $this->contents['LANG_EDIT_EXPENSE_ITEM'] = 'Chỉnh sửa Khoản mục Chi phí';
        $this->contents['LANG_DELETE_EXPENSE_ITEM'] = 'Xóa mục Chi phí';
        $this->contents['LANG_SEARCH_EXPENSE_TYPE'] = 'Loại chi phí tìm kiếm';
    }
}
?>