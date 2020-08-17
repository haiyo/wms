<?php
namespace Aurora;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Friday, May 18, 2012
 * @version $Id: DraftMessageRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DraftMessageRes extends Resource {


    /**
    * DraftMessageRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_DRAFT_ITEMS'] = 'Draft Items';
	}
}
?>