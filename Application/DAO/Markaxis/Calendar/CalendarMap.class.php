<?php
namespace Markaxis\Calendar;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CalendarMap.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarMap extends \DAO {


    // Properties


    /**
    * CalendarMap Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
    }


    /**
    * Retrieve map by eventID
    * @return mixed
    */
    public function getByEventID( $eventID ) {
        $sql = $this->DB->select( 'SELECT * FROM markaxis_event_map
                                   WHERE eventID = "' . (int)$eventID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }
}
?>