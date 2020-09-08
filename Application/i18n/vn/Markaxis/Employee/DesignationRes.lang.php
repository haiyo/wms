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
        $this->contents['LANG_DELETE_ORPHAN_GROUPS'] = 'Xóa nhóm mồ côi';
        $this->contents['LANG_DELETED_SELECTED_DESIGNATIONS'] = 'Xóa các chỉ định đã chọn';
        $this->contents['LANG_ENTER_GROUP_TITLE'] = 'Nhập tiêu đề nhóm';
        $this->contents['LANG_PLEASE_ENTER_GROUP_TITLE'] = 'Please enter a Group Title';
        $this->contents['LANG_NOTE'] = 'Ghi chú';
        $this->contents['LANG_DESIGNATION_GROUP_DESCRIPT'] = 'Nhóm mới tạo sẽ không xuất hiện trong danh sách bảng cho đến khi chỉ định được chỉ định cho nhóm đó';
        $this->contents['LANG_DESIGNATION_TITLE'] = 'Chức danh';
        $this->contents['LANG_ENTER_DESIGNATION_TITLE'] = 'Nhập chức danh chỉ định';
        $this->contents['LANG_ENTER_DESIGNATION_DESCRIPTIONS'] = 'Nhập mô tả chỉ định';
        $this->contents['LANG_DESIGNATION_GROUP'] = 'Nhóm chỉ định';
        $this->contents['LANG_EDIT_DESIGNATION'] = 'Chỉnh sửa chỉ định';
        $this->contents['LANG_SELECT_DESIGNATION_GROUP'] = 'Vui lòng chọn một Nhóm chỉ định';
        $this->contents['LANG_ENTER_DESIGNATION_TITLE'] = 'Vui lòng nhập một chức danh';
        $this->contents['LANG_CREATE_ANOTHER_DESIGNATION'] = 'Tạo một chỉ định khác';
        $this->contents['LANG_DESIGNATIONS_UNDER_GROUP_DELETED'] = 'Tất cả các chỉ định trong nhóm này sẽ bị xóa!';
        $this->contents['LANG_NO_DESIGNATION_SELECTED'] = 'Không có chỉ định nào được chọn';
        $this->contents['LANG_DELETE_SELECTED_DESIGNATIONS'] = 'Bạn có chắc chắn muốn xóa các chỉ định đã chọn không?';
        $this->contents['LANG_DELETE_DESIGNATION'] = 'Xóa chỉ định';
        $this->contents['LANG_CREATE_NEW_GROUP'] = 'Create New Group';
        $this->contents['LANG_CREATE_ANOTHER_GROUP'] = 'Create Another Group';
        $this->contents['LANG_EDIT_GROUP'] = 'Chỉnh sửa nhóm';
        $this->contents['LANG_DELETE_GROUP'] = 'Xóa nhóm';
        $this->contents['LANG_SEARCH_DESIGNATION'] = 'Chỉ định tìm kiếm';
        $this->contents['LANG_CONFIRM_DELETE_ALL_ORPHAN_GROUPS'] = 'Bạn có chắc chắn muốn xóa tất cả các nhóm mồ côi không?';
        $this->contents['LANG_GROUPS_EMPTY_DESIGNATION_DELETED'] = 'Tất cả các nhóm có chỉ định trống sẽ bị xóa';
        $this->contents['LANG_ORPHAN_GROUPS_SUCCESSFULLY_DELETE'] = '{count} nhóm mồ côi đã được xóa thành công!';
        $this->contents['LANG_NO_ORPHAN_GROUPS'] = 'Hiện không có nhóm mồ côi';
    }
}
?>