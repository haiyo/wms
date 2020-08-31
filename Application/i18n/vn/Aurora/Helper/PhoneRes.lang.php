<?php
namespace Aurora\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: PhoneRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PhoneRes extends Resource {


    /**
    * PhoneRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_HOME']   = 'Trang Chủ';
        $this->contents['LANG_WORK']   = 'Công việc';
        $this->contents['LANG_MOBILE'] = 'Di động';
        $this->contents['LANG_FAX']    = 'Số fax';
        $this->contents['LANG_OTHER']  = 'Khác';
	}
}
?>