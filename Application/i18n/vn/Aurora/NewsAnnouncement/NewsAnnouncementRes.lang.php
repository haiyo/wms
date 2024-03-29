<?php
namespace Aurora\NewsAnnouncement;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: NewsAnnouncementRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NewsAnnouncementRes extends Resource {


    /**
    * NewsAnnouncementRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        
        $this->contents = array( );
        $this->contents['LANG_NO_NEWS_OR_ANNOUNCEMENT'] = 'Hiện tại không có tin tức và thông báo';
        $this->contents['LANG_NEWS_ANNOUNCEMENT'] = 'Tin tức và Thông báo';
        $this->contents['LANG_ADD_NEW_CONTENT'] = 'Thêm nội dung mới';
        $this->contents['LANG_MANAGE'] = 'Quản lý';
        $this->contents['LANG_ANNOUNCEMENT'] = 'Sự thông báo';
        $this->contents['LANG_NEWS'] = 'Tin tức';
        $this->contents['LANG_CREATE_NEW_CONTENT'] = 'Tạo nội dung mới';
        $this->contents['LANG_SELECT_CONTENT_TYPE'] = 'Chọn loại nội dung';
        $this->contents['LANG_TITLE'] = 'Tiêu đề';
        $this->contents['LANG_PLEASE_SELECT_CONTENT_TYPE'] = 'Vui lòng chọn một loại nội dung';
        $this->contents['LANG_PLEASE_ENTER_TITLE'] = 'Vui lòng nhập tiêu đề';
        $this->contents['LANG_PLEASE_ENTER_CONTENT'] = 'Vui lòng nhập nội dung';
        $this->contents['LANG_CONTENT_TYPE'] = 'Loại nội dung';
        $this->contents['LANG_AUTHOR'] = 'Tác giả';
        $this->contents['LANG_DATE_CREATED'] = 'Ngày tạo';
        $this->contents['LANG_ENTER_TITLE_FOR_CONTENT'] = 'Nhập tiêu đề cho nội dung này';
        $this->contents['LANG_CONTENT'] = 'Nội dung';
        $this->contents['LANG_SEARCH_TITLE_AUTHOR'] = 'Tên tìm kiếm hoặc tên tác giả';
        $this->contents['LANG_EDIT_CONTENT'] = 'Chỉnh sửa nội dung';
        $this->contents['LANG_DELETE_CONTENT'] = 'Xóa nội dung';
        $this->contents['LANG_CONTENT_CREATED_SUCCESSFULLY'] = 'Nội dung đã được tạo thành công!';
	}
}
?>