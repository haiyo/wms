<?php
namespace Markaxis\Calendar;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CalendarMapModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarMapModel extends \Model {


    // Properties


    /**
    * CalendarMapModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
        $this->info['address'] = '';
	}


    /**
    * Get event
    * @return bool
    
    public function getByEventID( $eventID ) {
        $CalendarMap = new CalendarMap( );
        return $CalendarMap->getByEventID( $eventID );
    }*/


    /**
    * Set new RSVP info on POST
    * @return bool
    */
    public function validate( ) {
        $CalendarModel = CalendarModel::getInstance( );
        $data   = $CalendarModel->getInfo('data');
        $sizeOf = sizeof( $data );

        for( $i=0; $i<$sizeOf; $i++ ) {
            preg_match( '/(.*)=(.*)/', $data[$i], $match );

            switch( $match[1] ) {
                case 'address' :
                $this->info['address'] = trim( htmlspecialchars( urldecode( $match[2] ) ) );

                // Is this a location based event?
                if( $this->info['address'] != '' ) {
                    $this->info['eventID'] = $CalendarModel->getInfo('eventID');
                    return true;
                }
                return false; // no location detected
                break;
            }
        }
        return true;
    }


    /**
    * Iterate through events and insert address if needed
    * @return mixed
    
    public function iterateAddress( $eventInfo ) {
        if( sizeof( $eventInfo ) > 0 ) {
            $CalendarMap = new CalendarMap( );
            foreach( $eventInfo as $key => $row ) {
                if( $row['map'] ) {
                    $mapInfo = $CalendarMap->getByEventID( $row['eventID'] );
                    $eventInfo[$key]['address'] = $mapInfo['address'];
                }
            }
        }
        return $eventInfo;
    }*/


    /**
    * Iterate through events and insert address if needed
    * @return mixed
    
    public function iterateRecurAddress( $eventInfo ) {
        if( sizeof( $eventInfo['data'] ) > 0 ) {
            $CalendarMap  = new CalendarMap( );
            $addressCache = array( );

            foreach( $eventInfo['data'] as $key => $eventArray ) {
                foreach( $eventArray as $key2 => $row ) {
                    if( $row['map'] ) {
                        if( !isset( $addressCache[$row['eventID']] ) ) {
                            $mapInfo = $CalendarMap->getByEventID( $row['eventID'] );
                            $addressCache[$row['eventID']] = $mapInfo['address'];
                        }
                        $eventArray[$key2]['address'] = $mapInfo['address'];
                    }
                }
                $eventInfo['data'][$key] = $eventArray;
            }
        }
        return $eventInfo;
    }*/


    /**
    * Save Map Info
    * @return mixed
    */
    public function save( ) {
        $Calendar = new Calendar( );
        /*$info = array( );
        $info['eventID'] = (int)$this->info['eventID'];
        $info['address'] = $this->info['address'];
        $CalendarMap->insert( 'markaxis_event_map', $info );*/

        $info = array( );
        $info['address'] = $this->info['address'];
        $Calendar->update( 'markaxis_event', $info, 'WHERE eventID = "' . (int)$this->info['eventID'] . '"' );
        return true;
    }
}
?>