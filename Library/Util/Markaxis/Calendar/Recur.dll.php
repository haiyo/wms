<?php
namespace Library\Util\Markaxis\Calendar;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: DayRecur.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

abstract class Recur {


    // Properties
    protected $seconds;
    protected $rangeStart;
    protected $rangeEnd;
    protected $recurTotal;
    protected $collection;
    protected $occurrences;

    // Object
    protected $Event;


    /**
    * DayRecur Constructor
    * @return void
    */
    function __construct( $rangeStart, $rangeEnd, $seconds=0 ) {
        $this->collection = array( );
        $this->rangeStart = $rangeStart;
        $this->rangeEnd   = $rangeEnd;
        $this->seconds    = (int)$seconds;
        $this->occurances = 0;
	}


    /**
    * Set Event Object and recurTotal property
    * @return void
    */
    public function setEvent( Event $Event ) {
        $this->Event = $Event;
        $this->recurTotal = $this->seconds*$this->Event->repeatTimes( );
    }


    /**
    * Check event if repeat till occurances
    * @return bool
    */
    public function inOccurrences( ) {
        // From event start date, calculate occurrences until currView end date.
        if( $this->Event->getInfo('endRecur') == 'afterOccur' && $this->Event->getInfo('occurrences') > 0 ) {
            if( $this->occurrences == $this->Event->getInfo('occurrences') ) return false;
            else $this->occurrences++;
        }
        return true;
    }


    /**
    * Check event if repeat till date specify
    * @return bool
    */
    public function untilDate( $date ) {
        if( $this->Event->getInfo('endRecur') == 'untilDate' &&
            $date > $this->Event->getInfo('untilDate') ) {
            return false;
        }
        return true;
    }

    
    /**
    * Get events formula
    * @return void
    */
    abstract public function getEvents( );
}
?>