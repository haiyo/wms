<?php
namespace Markaxis;
use \File, \Date, \DateTime;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: DayRecur.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DayRecur extends Recur {


    // Properties


    /**
    * DayRecur Constructor
    * @return void
    */
    function __construct( $rangeStart, $rangeEnd ) {
        parent::__construct( new DateTime( $rangeStart ),
                             new DateTime( $rangeEnd   ), 86400 );
	}


    /**
    * Set event to collection if found
    * @return void
    */
    public function setCollection( $eventInfo ) {
        $eventInfo['start'] = $this->rangeStart->format('Y-m-d ' . $this->Event->getInfo('start', 'H:i:s') );
        $eventInfo['end']   = date('Y-m-d ' . $this->Event->getInfo('end', 'H:i:s'),
                                $this->rangeStart->format('U')+$this->Event->getTimeDiff( ) );
        $this->collection[] = $eventInfo;
    }


    /**
    * Set event to collection if found
    * @return void
    */
    public function getRecurTotal( ) {
        return $this->recurTotal = $this->Event->repeatTimes( );
    }


    /**
    * Get events formula
    * @return mixed
    */
    public function getEvents( ) {
        // Find the first occurance of the event
        $startDate = new DateTime( $this->Event->getInfo('start', 'Y-m-d') );
        $startDate = $startDate->format('U');

        $this->rangeStart->setDate( $this->Event->getInfo('start', 'Y'),
                                    $this->Event->getInfo('start', 'm'),
                                    $this->Event->getInfo('start', 'd') );

        // Loop thru the range and find occurring events
        while( $this->rangeStart <= $this->rangeEnd ) {
            if( $this->rangeStart->format('U') >= $startDate ) {
                if( $this->untilDate( $this->rangeStart->format('Y-m-d') ) ) {
                    $this->setCollection( $this->Event->getInfo( ) );
                }
                else break;
            }
            $this->rangeStart->modify('+' . $this->Event->repeatTimes( ) . ' ' . $this->Event->getInfo('recurType') );
        }
        return $this->collection;
    }
}
?>