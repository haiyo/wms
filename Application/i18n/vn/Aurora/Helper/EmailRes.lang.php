<?php
namespace Aurora\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: EmailRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EmailRes extends Resource {


    /**
    * EmailRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_PERSONAL'] = 'Personal';
        $this->contents['LANG_WORK']     = 'Work';
        $this->contents['LANG_AIM']      = 'AIM';
        $this->contents['LANG_ICQ']      = 'ICQ';
        $this->contents['LANG_MSN']      = 'MSN';
        $this->contents['LANG_SKYPE']    = 'Skype';
        $this->contents['LANG_GTALK']    = 'Google Talk';
        $this->contents['LANG_YMSG']     = 'Yahoo IM';
        $this->contents['LANG_OTHER']    = 'Other';
	}
}
?>