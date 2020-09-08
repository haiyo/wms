<?php
namespace Aurora\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: SMTPConnectionRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class SMTPConnectionRes extends Resource {


    // Properties


    /**
    * SMTPConnectionRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_NONE']  = 'None';
        $this->contents['LANG_TLS'] = 'Transport Layer Security (TLS)';
        $this->contents['LANG_SSL'] = 'Secure Sockets Layer (SSL)';
	}
}
?>