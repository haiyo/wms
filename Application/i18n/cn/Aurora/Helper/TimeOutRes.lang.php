<?php
namespace Aurora\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: TimeOutRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TimeOutRes extends Resource {


    // Properties


    /**
    * TimeOutRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        $this->contents = array( );
        $this->contents['LANG_NEVER'] = 'Never';
        $this->contents['LANG_N_MINUTE'] = '{n} Minute|Minutes';
        $this->contents['LANG_N_HOUR'] = '{n} Hour|Hours';
	}
}
?>