<?php
namespace Markaxis\Calendar;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: AttachmentRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AttachmentRes extends Resource {


    /**
    * AttachmentRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_SELECT_FILES'] = 'Chọn tệp tin';
        $this->contents['LANG_CLICK_BROWSE'] = 'Đính kèm tệp';
        $this->contents['LANG_REMOVE_FILE'] = 'Xóa tệp';
        $this->contents['LANG_DELETE_FILE'] = 'Xóa tài liệu';
        $this->contents['LANG_BROWSE'] = 'Duyệt qua';
        $this->contents['LANG_DRAG_TEXT'] = 'Kéo và thả tệp vào đây';
        $this->contents['LANG_SELECT_FILE_TEXT'] = 'Bạn có thể chọn nhiều tệp cùng một lúc';
        $this->contents['LANG_FILE_SIZE_OVER_LIMIT'] = 'Kích thước tệp vượt quá giới hạn 5MB';
        $this->contents['LANG_ATTACHMENTS'] = 'Tệp đính kèm';
        $this->contents['LANG_FILE_SIZE'] = 'Kích thước tập tin';
        $this->contents['LANG_VIEW'] = 'Lượt xem';
        $this->contents['LANG_DOWNLOAD'] = 'Tải xuống';
        $this->contents['LANG_DELETE'] = 'Xóa bỏ';
        $this->contents['LANG_DELETE_CONFIRM'] = 'Tệp này đã được tải lên. Bạn có chắc chắn muốn xóa nó? Hành động này không thể được hoàn tác.';
	}
}
?>