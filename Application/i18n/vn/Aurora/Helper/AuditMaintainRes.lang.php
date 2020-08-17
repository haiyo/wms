<?php
namespace Aurora\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: AuditMaintainRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AuditMaintainRes extends Resource {


    // Properties


    /**
    * AuditMaintainRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        $this->contents = array( );
        $this->contents['LANG_NEVER_PURGE'] = 'Never Purge (Manually)';
        $this->contents['LANG_PURGE_N_OLD'] = 'Purge records more than {n} month|months old';
	}
}
?>