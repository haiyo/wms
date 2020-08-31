<?php
namespace Aurora\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: PermRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PermRes extends Resource {


    /**
    * PermRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_EVERYONE'] = 'Tất cả mọi người';
        $this->contents['LANG_ONLY_ME'] = 'Chỉ có tôi';
        $this->contents['LANG_SPECIFIC_ROLES'] = 'Vai trò cụ thể';
	}
}
?>