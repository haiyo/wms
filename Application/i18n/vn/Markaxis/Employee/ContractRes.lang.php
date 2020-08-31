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
        $this->contents['LANG_BULK_ACTION'] = 'Hành động hàng loạt';
        $this->contents['LANG_DESCRIPTION'] = 'Sự miêu tả';
        $this->contents['LANG_NO_OF_EMPLOYEE'] = 'Số lượng nhân viên';
        $this->contents['LANG_ACTIONS'] = 'Hành động';
        $this->contents['LANG_CANCEL'] = 'Huỷ bỏ';
        $this->contents['LANG_SUBMIT'] = 'Gửi đi';
        $this->contents['LANG_DELETE_SELECTED_CONTRACTS'] = 'Xóa các hợp đồng đã chọn';
        $this->contents['LANG_CONTRACT_TITLE'] = 'Tiêu đề hợp đồng';
        $this->contents['LANG_ENTER_CONTRACT_TITLE'] = 'Nhập tiêu đề hợp đồng';
        $this->contents['LANG_ENTER_CONTRACT_DESCRIPTION'] = 'Nhập mô tả hợp đồng';
    }
}
?>