<?php
namespace Aurora\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: StrongNameRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class StrongNameRes extends Resource {


    // Properties


    /**
    * StrongNameRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_NONE'] = 'None';
        $this->contents['LANG_MIN_MAX'] = 'Min. 6 and Max 16 Characters';
        $this->contents['LANG_ALPHANUM'] = 'Must consist Alphanumeric Characters';
        $this->contents['LANG_ALL_RULES'] = 'Apply all 2 rules above';
	}
}
?>