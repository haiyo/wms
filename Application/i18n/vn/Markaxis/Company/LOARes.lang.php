<?php
namespace Markaxis\Company;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LOARes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LOARes extends Resource {


    /**
    * LOARes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        
        $this->contents = array( );
        $this->contents['LANG_LETTER_OF_APPOINTMENT'] = 'Thư hẹn';
        $this->contents['LANG_CREATE_NEW_LOA'] = 'Tạo thư hẹn mới';
        $this->contents['LANG_FOR_WHICH_DESIGNATION'] = 'Cho sự chỉ định nào';
        $this->contents['LANG_PLEASE_SELECT_DESIGNATION'] = 'Vui lòng chọn một Chỉ định';
        $this->contents['LANG_PLEASE_ENTER_CONTENT'] = 'Vui lòng nhập nội dung';
        $this->contents['LANG_FOR_DESIGNATION'] = 'Để chỉ định(s)';
        $this->contents['LANG_LAST_UPDATED_BY'] = 'Cập nhật lần cuối bởi';
        $this->contents['LANG_LAST_UPDATED'] = 'Cập nhật mới nhất';
        $this->contents['LANG_ACTIONS'] = 'Hành động';
        $this->contents['LANG_CONTENT'] = 'Nội dung';
        $this->contents['LANG_DISCARD'] = 'Bỏ';
        $this->contents['LANG_SAVE_CHANGES'] = 'Lưu thay đổi';
	}
}
?>