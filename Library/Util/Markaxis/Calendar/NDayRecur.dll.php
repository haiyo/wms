<?php
namespace Markaxis;
use \DateTime;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: NDayRecur.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NDayRecur extends DayRecur {


    // Properties
    protected $nDay;


    /**
    * NDayRecur Constructor
    * @return void
    */
    function __construct( $rangeStart, $rangeEnd ) {
        parent::__construct( $rangeStart, $rangeEnd );
        $this->nDay = array( );
    }


    /**
    * Set the NDay
    * @return void
    */
    public function setNDay( $nDay ) {
        if( is_array( $nDay ) ) {
            $this->nDay = $nDay;
        }
        else die( 'NDay must be an array' );
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
        while( $this->rangeStart->format('U') <= $this->rangeEnd->format('U') ) {
            if( $this->rangeStart->format('U') >= $startDate && in_array( $this->rangeStart->format('N'), $this->nDay ) ) {
                if( $this->untilDate( $this->rangeStart->format('Y-m-d') ) ) {
                    $this->setCollection( $this->Event->getInfo( ) );
                }
            }
            $this->rangeStart->modify('+1 day' );
        }
        return $this->collection;
    }
}
?>