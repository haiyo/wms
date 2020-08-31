<?php
namespace Markaxis\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LabelRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LabelRes extends Resource {


    /**
    * LabelRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        
        $this->contents = array( );
        $this->contents['LANG_BUSINESS'] = 'Kinh doanh';
        $this->contents['LANG_IMPORTANT'] = 'Quan trọng';
        $this->contents['LANG_PREPARATION'] = 'Sự chuẩn bị';
        $this->contents['LANG_PERSONAL'] = 'Cá nhân';
        $this->contents['LANG_BIRTHDAY'] = 'Sinh nhật';
        $this->contents['LANG_MUST_ATTEND'] = 'Phải tham gia';
        $this->contents['LANG_PHONE_CALL'] = 'Gọi điện';
        $this->contents['LANG_VACATION'] = 'Kỳ nghỉ';
        $this->contents['LANG_ANNIVERSARY'] = 'Ngày kỷ niệm';
        $this->contents['LANG_TRAVEL'] = 'Du lịch';
        $this->contents['LANG_MANAGE_LABEL'] = 'Quản lý nhãn';
	}
}
?>