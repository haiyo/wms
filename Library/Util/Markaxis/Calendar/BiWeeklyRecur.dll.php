<?php
namespace Library\Util\Markaxis\Calendar;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: BiWeeklyRecur.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class BiWeeklyRecur extends DayRecur {


    // Properties


    /**
    * BiWeeklyRecur Constructor
    * @return void
    */
    function __construct( $rangeStart, $rangeEnd ) {
        parent::__construct( $rangeStart, $rangeEnd );
        $this->seconds = 1209600;
	}
}
?>