<?php
namespace Markaxis;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: WeekRecur.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class WeekRecur extends DayRecur {


    // Properties


    /**
    * WeekRecur Constructor
    * @return void
    */
    function __construct( $rangeStart, $rangeEnd ) {
        parent::__construct( $rangeStart, $rangeEnd );
        $this->seconds = 604800;
	}
}
?>