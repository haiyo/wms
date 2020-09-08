<?php
namespace Aurora\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: AuthFieldRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AuthFieldRes extends Resource {


    // Properties


    /**
    * AuthFieldRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_EMAIL'] = '电子邮件地址';
        $this->contents['LANG_USERNAME'] = '唯一的用户名';
	}
}
?>