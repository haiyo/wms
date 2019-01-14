<?php
namespace Aurora\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: TimeRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TimeRes extends Resource {


    // Properties


    /**
    * TimeRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_ANTE_MERIDIEM'] = 'am';
        $this->contents['LANG_POST_MERIDIEM'] = 'pm';
	}
}
?>