<?php
namespace Aurora;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Friday, May 18, 2012
 * @version $Id: SentMessageRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class SentMessageRes extends Resource {


    /**
    * SentMessageRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_SENT_ITEMS'] = 'Sent Items';
	}
}
?>