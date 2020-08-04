<?php
namespace Markaxis\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ReminderRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ReminderRes extends Resource {


    /**
    * ReminderRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_ONE_HOUR_BEFORE'] = '{n} hour|hours before due';
        $this->contents['LANG_ONE_DAY_BEFORE'] = '{n} day|days before due';
	}
}
?>