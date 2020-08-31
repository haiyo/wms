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
        $this->contents['LANG_SINGLE'] = 'Độc thân';
        $this->contents['LANG_MARRIED'] = 'Cưới nhau';
        $this->contents['LANG_DIVORCED'] = 'Đã ly hôn';
        $this->contents['LANG_WIDOW'] = 'Góa phụ';
	}
}
?>