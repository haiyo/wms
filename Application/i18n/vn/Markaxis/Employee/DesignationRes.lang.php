<?php
namespace Markaxis\Employee;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: DesignationRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DesignationRes extends Resource {


    // Properties


    /**
     * DesignationRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_DESIGNATION'] = 'Chỉ định';
        $this->contents['LANG_CREATE_NEW_DESIGNATION'] = 'Tạo chỉ định mới';
        $this->contents['LANG_CREATE_NEW_DESIGNATION_GROUP'] = 'Tạo nhóm chỉ định mới';
        $this->contents['LANG_DESIGNATION_GROUP_TITLE'] = 'Nhóm chỉ định / Tiêu đề';
        $this->contents['LANG_BULK_ACTION'] = 'Hành động hàng loạt';
        $this->contents['LANG_DESCRIPTION'] = 'Sự miêu tả';
        $this->contents['LANG_NO_OF_EMPLOYEE'] = 'Số lượng nhân viên';
        $this->contents['LANG_ACTIONS'] = 'Hành động';
        $this->contents['LANG_CANCEL'] = 'Huỷ bỏ';
        $this->contents['LANG_SUBMIT'] = 'Gửi đi';
        $this->contents['LANG_DELETE_ORPHAN_GROUPS'] = 'Xóa nhóm mồ côi';
        $this->contents['LANG_DELETED_SELECTED_DESIGNATIONS'] = 'Xóa các chỉ định đã chọn';
        $this->contents['LANG_ENTER_GROUP_TITLE'] = 'Nhập tiêu đề nhóm';
        $this->contents['LANG_NOTE'] = 'Ghi chú';
        $this->contents['LANG_DESIGNATION_GROUP_DESCRIPT'] = 'Nhóm mới tạo sẽ không xuất hiện trong danh sách bảng cho đến khi chỉ định được chỉ định cho nhóm đó';
        $this->contents['LANG_DESIGNATION_TITLE'] = 'Chức danh';
        $this->contents['LANG_ENTER_DESIGNATION_TITLE'] = 'Nhập chức danh chỉ định';
        $this->contents['LANG_ENTER_DESIGNATION_DESCRIPTIONS'] = 'Nhập mô tả chỉ định';
        $this->contents['LANG_DESIGNATION_GROUP'] = 'Nhóm chỉ định';
    }
}
?>