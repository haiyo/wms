<?php
namespace Aurora\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: AccountStatusRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AccountStatusRes extends Resource {


    /**
    * AccountStatusRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_ACTIVE'] = 'Hoạt động';
        $this->contents['LANG_PENDING'] = 'Đang chờ xử lý';
        $this->contents['LANG_SUSPENDED'] = 'Đình chỉ';
	}
}
?>