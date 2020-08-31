<?php
namespace Aurora\Page;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: NotFoundRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NotFoundRes extends Resource {


    /**
     * NotFoundRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_404_NOT_FOUND'] = '404 Không tìm thấy';
        $this->contents['LANG_NOT_FOUND_INFO'] = 'Một lỗi đã xảy ra.<br />Bản ghi không tồn tại nữa hoặc không thể tìm thấy trang!';
    }
}
?>