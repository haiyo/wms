<?php
namespace Library\Util\Markaxis\Calendar;
use \DateTime;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: WeekDayRecur.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class WeekDayRecur extends DayRecur {


    // Properties


    /**
    * WeekDayRecur Constructor
    * @return void
    */
    function __construct( $rangeStart, $rangeEnd ) {
        parent::__construct( $rangeStart, $rangeEnd );
	}


    /**
    * Get events formula
    * @return mixed
    */
    public function getEvents( ) {        
        // Find the first occurance of the event
        $startDate = new DateTime( $this->Event->getInfo('start', 'Y-m-d') );
        $startDate = $startDate->format('U');

        while( 0 != (($this->rangeStart->format('U')-$startDate)%$this->recurTotal)) {
            $this->rangeStart->modify('+1 day');
        }

        // Loop thru the range and find occurring events
        while( $this->rangeStart <= $this->rangeEnd ) {
            if( $this->rangeStart->format('U') >= $startDate && $this->rangeStart->format('N') < 6 ) {
                if( $this->untilDate( $this->rangeStart->format('Y-m-d') ) ) {
                    $this->setCollection( $this->Event->getInfo( ) );
                }
                else break;
            }
            $this->rangeStart->modify('+1 ' . $this->Event->getInfo('recurType'));
        }
        return $this->collection;
    }
}
?>