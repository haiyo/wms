<?php
namespace Aurora\User;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: RolePermRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RolePermRes extends Resource {


    /**
    * RolePermRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        
        $this->contents = array( );
        $this->contents['LANG_ROLES_PERMISSIONS'] = 'Vai trò và Quyền';
        $this->contents['LANG_CREATE_NEW_ROLE'] = 'Tạo vai trò mới';
        $this->contents['LANG_DELETE_ROLE'] = 'Xóa vai trò';
        $this->contents['LANG_SAVE'] = 'Lưu các thiết lập';
        $this->contents['LANG_CONFIRM_CLOSE'] = 'Bạn chưa lưu các thay đổi của mình đối với cài đặt quyền. Bạn có chắc là muốn hủy bỏ?';
        $this->contents['LANG_PERMISSION_SAVED'] = 'Quyền đã được lưu';
        $this->contents['LANG_NO_DATA_SAVED'] = 'Bạn không thực hiện bất kỳ thay đổi nào đối với cài đặt quyền. Không có dữ liệu nào được lưu';
        $this->contents['LANG_CONFIRM_DELETE_ROLE'] = 'Bạn có chắc chắn muốn xóa {roleTitle} vai trò?';
        $this->contents['LANG_ROLE_TITLE_EMPTY'] = 'Vui lòng nhập một chức danh';
        $this->contents['LANG_NEW_ROLE'] = 'Vai trò mới';
        $this->contents['LANG_ROLE_NAME'] = 'Tên vai trò';
        $this->contents['LANG_ROLE_TITLE'] = 'Chức danh vai trò';
        $this->contents['LANG_ENTER_ROLE_TITLE'] = 'Nhập tiêu đề vai trò';
        $this->contents['LANG_ROLE_DESCRIPTION'] = 'Mô tả vai trò';
        $this->contents['LANG_ENTER_ROLE_DESCRIPTION'] = 'Nhập mô tả vai trò';
        $this->contents['LANG_DEFINE_PERMISSIONS'] = 'Xác định quyền';
        $this->contents['LANG_SAVE_PERMISSIONS'] = 'Lưu quyền';

        $this->contents['LANG_EDIT_ROLE'] = 'Chỉnh sửa vai trò';
        $this->contents['LANG_CREATE_ANOTHER_ROLE'] = 'Tạo một vai trò khác';
        $this->contents['LANG_PERMISSIONS_SAVED'] = 'Quyền đã được lưu!';
        $this->contents['LANG_SEARCH_ROLE_NAME'] = 'Tìm kiếm tên vai trò';
	}
}
?>