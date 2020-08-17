<?php
namespace Aurora\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: PermRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PermRes extends Resource {


    /**
    * PermRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_EVERYONE'] = 'Everyone';
        $this->contents['LANG_ONLY_ME'] = 'Only Me';
        $this->contents['LANG_SPECIFIC_ROLES'] = 'Specific Roles';
	}
}
?>