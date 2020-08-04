<?php
namespace Library\Util\Markaxis\Calendar;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: YearRecur.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class YearRecur extends MonthRecur {


    // Properties


    /**
    * YearRecur Constructor
    * @return void
    */
    function __construct( $rangeStart, $rangeEnd ) {
        parent::__construct( $rangeStart, $rangeEnd );
	}


    /**
    * Set event to collection if found
    * @return void
    */
    public function getRecurTotal( ) {
        return $this->recurTotal = $this->Event->repeatTimes( )*12;
    }
}
?>