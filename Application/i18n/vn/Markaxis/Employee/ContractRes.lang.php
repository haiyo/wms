<?php
namespace Markaxis\Employee;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ContractRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ContractRes extends Resource {


    // Properties


    /**
     * ContractRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_CONTRACT_TYPE'] = 'Thể loại hợp đồng';
        $this->contents['LANG_CREATE_NEW_CONTRACT_TYPE'] = 'Tạo loại hợp đồng mới';
        $this->contents['LANG_DELETE_SELECTED_CONTRACTS'] = 'Xóa các hợp đồng đã chọn';
        $this->contents['LANG_CONTRACT_TITLE'] = 'Tiêu đề hợp đồng';
        $this->contents['LANG_ENTER_CONTRACT_TITLE'] = 'Nhập tiêu đề hợp đồng';
        $this->contents['LANG_ENTER_CONTRACT_DESCRIPTION'] = 'Nhập mô tả hợp đồng';
        $this->contents['LANG_EDIT_CONTRACT'] = 'Chỉnh sửa hợp đồng';
        $this->contents['LANG_CREATE_NEW_CONTRACT'] = 'Tạo hợp đồng mới';
        $this->contents['LANG_PLEASE_ENTER_CONTRACT_TITLE'] = 'Vui lòng nhập Tiêu đề Hợp đồng';
        $this->contents['LANG_CREATE_ANOTHER_CONTRACT'] = 'Tạo một hợp đồng khác';
        $this->contents['LANG_NO_CONTRACT_SELECTED'] = 'Không có hợp đồng nào được chọn';
        $this->contents['LANG_CONFIRM_DELETE_CONTRACT'] = 'Bạn có chắc chắn muốn xóa các hợp đồng đã chọn không?';
        $this->contents['LANG_EDIT_CONTRACT_TYPE'] = 'Chỉnh sửa loại hợp đồng';
        $this->contents['LANG_DELETE_CONTRACT_TYPE'] = 'Xóa loại hợp đồng';
        $this->contents['LANG_SEARCH_CONTRACT_TYPE'] = 'Loại hợp đồng tìm kiếm';
    }
}
?>