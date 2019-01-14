<?php
namespace Aurora\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: ExpiryRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ExpiryRes extends Resource {


    // Properties


    /**
    * ExpiryRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        $this->contents = array( );
        $this->contents['LANG_NEVER'] = 'Never';
        $this->contents['LANG_N_MONTH'] = '{n} Month|Months';
	}
}
?>