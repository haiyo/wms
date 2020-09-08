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
        $this->contents['LANG_EDIT_COMPETENCY'] = 'Chỉnh sửa năng lực';
        $this->contents['LANG_DELETE_COMPETENCY'] = 'Xóa năng lực';
        $this->contents['LANG_CREATE_NEW_COMPETENCY'] = 'Tạo năng lực mới';
        $this->contents['LANG_COMPETENCY_SUCCESSFULLY_CREATED'] = '{competency} đã được tạo thành công!';
        $this->contents['LANG_PLEASE_ENTER_COMPETENCY'] = 'Vui lòng nhập Năng lực';
        $this->contents['LANG_CREATE_ANOTHER_COMPETENCY'] = 'Tạo năng lực khác';
        $this->contents['LANG_NO_COMPETENCY_SELECTED'] = 'Không có năng lực nào được chọn';
        $this->contents['LANG_SEARCH_COMPETENCY'] = 'Năng lực tìm kiếm';
        $this->contents['LANG_ARE_YOU_SURE_DELETE_COMPETENCIES'] = 'Bạn có chắc chắn muốn xóa các năng lực đã chọn không?';
    }
}
?>