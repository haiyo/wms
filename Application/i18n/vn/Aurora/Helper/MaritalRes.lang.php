<?php
namespace Aurora\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: MaritalRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class MaritalRes extends Resource {


    /**
    * MaritalRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_SINGLE'] = 'Single';
        $this->contents['LANG_MARRIED'] = 'Married';
        $this->contents['LANG_DIVORCED'] = 'Divorced';
        $this->contents['LANG_WIDOW'] = 'Widow';
	}
}
?>