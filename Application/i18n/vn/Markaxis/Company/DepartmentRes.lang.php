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
        $this->contents['LANG_NO_OF_EMPLOYEE'] = 'Số lượng nhân viên';
        $this->contents['LANG_ACTIONS'] = 'Hành động';
        $this->contents['LANG_ENTER_DEPARTMENT_NAME'] = 'Nhập tên bộ phận';
        $this->contents['LANG_DEPARTMENT_MANAGER'] = 'Giám đốc bộ phận';
        $this->contents['LANG_ENTER_MANAGER_NAME'] = 'Nhập tên người quản lý';
        $this->contents['LANG_DISCARD'] = 'Bỏ';
        $this->contents['LANG_SUBMIT'] = 'Gửi đi';
    }
}
?>