<?php
namespace Markaxis\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: RecurRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RecurRes extends Resource {


    // Properties


    /**
    * RecurRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_HOURLY'] = 'Hàng giờ';
        $this->contents['LANG_DAILY'] = 'Hằng ngày';
        $this->contents['LANG_WEEKLY'] = 'Hàng tuần';
        $this->contents['LANG_EVERY_2_WEEKS'] = 'Mỗi 2 tuần';
        $this->contents['LANG_MONTHLY'] = 'Hàng tháng';
        $this->contents['LANG_YEARLY'] = 'Hàng năm';
        $this->contents['LANG_MON_FRI'] = 'Mỗi ngày trong tuần (Thứ Hai-Thứ Sáu)';
        $this->contents['LANG_MON_WED_FRI'] = 'Mỗi Thứ Hai, Thứ Tư và Thứ Sáu';
        $this->contents['LANG_TUE_THUR'] = 'Thứ Ba và thứ Năm hàng tuần';
        $this->contents['LANG_DAY_OF_MONTH'] = 'Hàng tháng theo ngày';
        $this->contents['LANG_NEVER'] = 'Không bao giờ';
        $this->contents['LANG_AFTER_OCCUR'] = 'Số lần lặp lại';
        $this->contents['LANG_UNTIL_DATE'] = 'Cho đến ngày';
	}
}
?>