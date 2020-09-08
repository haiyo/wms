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
        $this->contents['LANG_HOME']   = 'Home';
        $this->contents['LANG_WORK']   = 'Work';
        $this->contents['LANG_MOBILE'] = 'Mobile';
        $this->contents['LANG_FAX']    = 'Fax';
        $this->contents['LANG_OTHER']  = 'Other';
	}
}
?>