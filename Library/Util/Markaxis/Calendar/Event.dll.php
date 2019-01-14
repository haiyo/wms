<?php
namespace Markaxis;
use \DateTime;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: Event.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Event {


    // Properties
    protected $eventInfo;


    /**
    * Event Constructor
    * @return void
    */
    function __construct( $eventInfo ) {
        if( is_array( $eventInfo ) && isset( $eventInfo['start'] ) && isset( $eventInfo['end'] ) ) {
            $this->eventInfo = $eventInfo;
            $this->eventInfo['start'] = new DateTime( $eventInfo['start'] );
            $this->eventInfo['end']   = new DateTime( $eventInfo['end']   );
        }
	}


    /**
    * Return the number of times to be repeat
    * @return int
    */
    public function repeatTimes( ) {
        if( isset( $this->eventInfo['repeatTimes'] ) ) {
            return $this->eventInfo['repeatTimes'];
        }
        return 1;
    }


    /**
    * Reeturn event info
    * @return mixed
    */
    public function getInfo( $key=NULL, $format='Y-m-d' ) {
        if( $format && ( $key == 'start' || $key == 'end' ) ) {
            return $this->eventInfo[$key]->format( $format );
        }
        else if( $key != NULL ) {
            return $this->eventInfo[$key];
        }
        return $this->eventInfo;
    }
    

    /**
    * Modify eventInfo value
    * @return void
    */
    public function setInfo( $key, $value ) {
        $this->eventInfo[$key] = $value;
    }


    /**
    * Return the number of seconds difference in the event start and end date
    * @return int
    */
    public function getTimeDiff( ) {
        return $this->eventInfo['end']->getTimestamp( )-$this->eventInfo['start']->getTimestamp( );
    }
}
?>