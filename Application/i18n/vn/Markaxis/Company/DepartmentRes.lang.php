<?php
namespace Markaxis\Company;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: DepartmentRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DepartmentRes extends Resource {


    // Properties


    /**
     * DepartmentRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_DEPARTMENT'] = 'Phòng ban';
        $this->contents['LANG_CREATE_NEW_DEPARTMENT'] = 'Tạo bộ phận mới';
        $this->contents['LANG_DEPARTMENT_NAME'] = 'Tên bộ phận';
        $this->contents['LANG_MANAGERS'] = 'Giám đốc';
        $this->contents['LANG_ENTER_DEPARTMENT_NAME'] = 'Nhập tên bộ phận';
        $this->contents['LANG_DEPARTMENT_MANAGER'] = 'Giám đốc bộ phận';
        $this->contents['LANG_ENTER_MANAGER_NAME'] = 'Nhập tên người quản lý';
        $this->contents['LANG_EDIT_DEPARTMENT'] = 'Chỉnh sửa bộ phận';
        $this->contents['LANG_ENTER_DEPARTMENT_NAME'] = 'Vui lòng nhập Tên bộ phận';
        $this->contents['LANG_ENTER_VALID_MANAGER'] = 'Vui lòng nhập một người quản lý hợp lệ';
        $this->contents['LANG_CREATE_ANOTHER_DEPARTMENT'] = 'Tạo một phòng ban khác';
        $this->contents['LANG_DELETE_DEPARTMENT'] = 'Xóa bộ phận';
        $this->contents['LANG_SEARCH_DEPARTMENT'] = 'Bộ phận tìm kiếm';
    }
}
?>