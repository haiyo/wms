<?php
namespace Markaxis\Employee;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: CompetencyRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CompetencyRes extends Resource {


    // Properties


    /**
     * CompetencyRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_COMPETENCY'] = 'Năng lực';
        $this->contents['LANG_CREATE_NEW_COMPETENCY'] = 'Tạo năng lực mới';
        $this->contents['LANG_DELETED_SELECTED_COMPETENCIES'] = 'Xóa năng lực đã chọn';
        $this->contents['LANG_COMPETENCY'] = 'Năng lực';
        $this->contents['LANG_ENTER_COMPETENCY'] = 'Nhập năng lực';
        $this->contents['LANG_COMPETENCY_DESCRIPTION'] = 'Mô tả năng lực';
        $this->contents['LANG_ENTER_COMPETENCY_DESCRIPTION'] = 'Nhập mô tả năng lực';
        $this->contents['LANG_DESCRIPTION'] = 'Sự miêu tả';
        $this->contents['LANG_BULK_ACTION'] = 'Hành động hàng loạt';
        $this->contents['LANG_NO_OF_EMPLOYEE'] = 'Số lượng nhân viên';
        $this->contents['LANG_ACTIONS'] = 'Hành động';
        $this->contents['LANG_CANCEL'] = 'Huỷ bỏ';
        $this->contents['LANG_SUBMIT'] = 'Gửi đi';
    }
}
?>