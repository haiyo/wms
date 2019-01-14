<?php
namespace Aurora\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: CacheTimeRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CacheTimeRes extends Resource {


    // Properties


    /**
    * CacheTimeRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        $this->contents = array( );
        $this->contents['LANG_NEVER'] = 'Never';
        $this->contents['LANG_REFRESH_CACHE'] = 'Refresh cache ';
        $this->contents['LANG_IF_CHANGES'] = 'only if there\'s changes';
        $this->contents['LANG_EVERY_N_SECOND'] = 'every {n} second|seconds';
	}
}
?>