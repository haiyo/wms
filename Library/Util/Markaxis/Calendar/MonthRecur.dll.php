<?php
namespace Library\Util\Markaxis\Calendar;
use \DateTime, \DateInterval;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: MonthRecur.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class MonthRecur extends Recur {


    // Properties
    protected $interval;
    protected $forceMonthEnd = false;


    /**
    * MonthRecur Constructor
    * @return void
    */
    function __construct( $rangeStart, $rangeEnd ) {
        parent::__construct( new DateTime( $rangeStart ), new DateTime( $rangeEnd ) );
	}


    /**
     * Set event to collection if found
     * @return void
     */
    public function forceMonthEnd( $bool ) {
        $this->forceMonthEnd = (bool)$bool;
    }


    /**
    * Return the next recurrence from the baseTime with supplied number of months with DST
    * and leap year in considerations.
    * For e.g: Basetme is on 1 Jan 2011 | Given 2 months, it will be 28 Feb 2011 in timestamp
    * @return int
    */
    public function getNextRecur( $baseTime=null, $months=1 ) {
        if( is_null( $baseTime ) ) $baseTime = time( );

        $xMonths = strtotime( '+' . $months . ' months', $baseTime );
        $before = (int)date( 'm', $baseTime )+12*(int)date( 'Y', $baseTime );
        $after  = (int)date( 'm', $xMonths )+12*(int)date( 'Y', $xMonths );

        if( $after > $months+$before ) {
            $xMonths = strtotime( date('Ym01His', $xMonths) . ' -1 day' );
        }
        return $xMonths;
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
        while( $this->rangeStart <= $this->rangeEnd ) {
            $currView  = mktime( 0, 0, 0, $this->rangeStart->format('m'),
                                                               $this->Event->getInfo('start', 'd'),
                                                               $this->rangeStart->format('Y') );

            $eventDate = mktime( 0, 0, 0, $this->Event->getInfo('start', 'm'),
                                                               $this->Event->getInfo('start', 'd'),
                                                               $this->Event->getInfo('start', 'Y') );

            $this->interval = round(($currView-$eventDate) / 60 / 60 / 24 / 30); // months difference

            $monthsAway = $this->Event->getInfo('start', 'm') + $this->interval; //8
            $recurMonth = $this->Event->getInfo('start', 'm') % $this->getRecurTotal( ); // 0

            if( $monthsAway % $this->getRecurTotal( ) == $recurMonth ) {
                // Seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)
                $nextRecur = $this->getNextRecur( $this->Event->getInfo('start', 'U'), $this->interval );
                $endRecur  = $this->getNextRecur( $this->Event->getInfo('end',   'U'), $this->interval );

                $startDate = date( 'Y-m-d', $nextRecur );

                if( $startDate >= $this->Event->getInfo('start') /*&& $this->untilDate( $startDate )*/ ) {
                    $eventInfo = $this->Event->getInfo( );

                    // Do the magic overwrite with new recur dates!
                    $format = $this->forceMonthEnd ? 'Y-m-t' : 'Y-m-d H:i:s';

                    $eventInfo['start'] = date( $format, $nextRecur );
                    $eventInfo['end']   = date( 'Y-m-d H:i:s', $endRecur  );

                    $this->collection[] = $eventInfo;
                    $this->Event->setInfo( 'start', new DateTime( $eventInfo['start'] ) );
                    $this->Event->setInfo( 'end', new DateTime( $eventInfo['end'] ) );
                }
            }
            $this->rangeStart = self::addMonth( $this->rangeStart, $this->rangeStart, $this->forceMonthEnd );
        }
        return $this->collection;
    }


    /**
     * Get events formula
     * @return mixed
     */
    public static function addMonth( DateTime $startDate, DateTime $currentDate, $forceMonthEnd=false ) {
        $addMon = clone $currentDate;
        $addMon->add( new DateInterval("P1M") );

        $nextMon = clone $currentDate;
        $nextMon->modify('last day of next month' );

        if( $addMon->format('n' ) == $nextMon->format('n' ) ) {
            $recurDay = $startDate->format('j');
            $daysInMon = $addMon->format('t');
            $currentDay = $currentDate->format('j');

            if( $recurDay > $currentDay && $recurDay <= $daysInMon ) {
                $addMon->setDate( $addMon->format('Y'), $addMon->format('n'), $recurDay );
            }
            else if( $forceMonthEnd ) {
                $addMon->setDate( $addMon->format('Y'), $addMon->format('n'), $daysInMon );
            }
            return $addMon;
        }
        else {
            return $nextMon;
        }
    }
}
?>