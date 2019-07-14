<?php
namespace Library\Util;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Sunday, July 29, 2012
 * @version $Id: Date.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Date {

    
    /**
    * Date Constructor
    * @return void
    */
    function __construct( ) {
        //
    }


    /**
    * Calculate years of age (input string: YYYY-MM-DD)
    * @param the file name
    * @returns void
    */
    public static function getDateStr( $month, $day, $year ) {
        if( checkdate( (int)$month, (int)$day, (int)$year ) ) {
            return $year . '-' . $month . '-' . $day;
        }
        return false;
    }
    
    
    /**
    *  Same as PHP's mktime but with a $tz parameter which
    *  is the timezone for converting the timestamp to GMT.
    *  If the user is on the east coast of the USA, this
    *  would be "-0400" in summer, and "-0500" in winter.
    */
    public static function mktime( $hr, $mi, $se, $mo, $dy, $yr, $tz ) {
        $timestamp = gmmktime($hr,$mi,$se,$mo,$dy,$yr);
        $offset    = (60 * 60) * ($tz / 100); // Seconds from GMT
        $timestamp = $timestamp - $offset;
        return $timestamp;
    }
    

    /**
    *  This is also the same format as PHP's date function,
    *  but with the additional timezone parameter which
    *  specifies the user's timezone.
    */
    public static function dateZone( $format, $timestamp, $tz ) {
        $offset = (60 * 60) * ($tz / 100); // Seconds from GMT
        $timestamp = $timestamp + $offset;
        return gmdate( $format, $timestamp );
    }
    
    
    /**
    * Calculate years of age (input string: YYYY-MM-DD)
    * @param the file name
    * @returns void
    */
    public static function getAge( $birthday ) {
        return \DateTime::createFromFormat('Y-m-d', $birthday)->diff(new \DateTime('now'))->y;
    }

    
    /**
    * Calculate years of age (input string: YYYY-MM-DD)
    * @param the file name
    * @returns void
    */
    public static function getZodiac( $time=null ) {
        if( $time == null ) {
            $time  = time( );
            $month = date( 'n', $time );
            $date  = date( 'd', $time );
        }
        else if( preg_match( '/(\d{4})-(\d{2})-(\d{2})/', $time, $parts ) ) {
            $time  = mktime( 0, 0, 0, $parts[2], $parts[3], $parts[1] );
            $month = date( 'n', $time );
            $date  = date( 'd', $time );
        }
        
        //Start days of months 0-11
        $h = array( 20, 19, 21, 20, 21, 22, 23, 23, 23, 23, 22, 22 );
        $s = array( 'Aquarius', 'Pisces', 'Aries', 'Taurus', 'Gemini', 'Cancer', 'Leo', 
                    'Virgo', 'Libra', 'Scorpio', 'Sagittarius', 'Capricorn' );

        if( $date < $h[$month-1] ) {
            return $s[$month-2 == -1 ? 11 : $month-2]; //Previous sign
        }
        else {
            return $s[$month-1]; //Current Sign
        }
    }


    /**
    * Return the number of days from a date range
    * @return int
    */
    public static function daysDiff( \DateTime $startDate, \DateTime $endDate, $weekdays=false ) {
        $endDate->modify('+1 day');
        $interval = $startDate->diff( $endDate );
        $days = $interval->days;

        // create an iterateable period of date (P1D equates to 1 day)
        $period = new \DatePeriod( $startDate, new \DateInterval('P1D'), $endDate );
        $holidays = array('2012-09-07');

        foreach( $period as $dt ) {
            $curr = $dt->format('D');

            // substract if Saturday or Sunday
            if ($curr == 'Sat' || $curr == 'Sun') {
                $days--;
            }
            elseif (in_array($dt->format('Y-m-d'), $holidays)) {
                $days--;
            }
        }
        return $days;
    }
    
    
    /**
    * Function to calculate date or time difference. Returns an array or
    * false on error.
    * @param string $start
    * @param string $end
    * @return array
    */
    public static function timeLeft( $start, $end ) {
        $uts['start'] = strtotime( $start );
        $uts['end']   = strtotime( $end );
        
        if( $uts['start'] !== -1 && $uts['end'] !== -1 ) {
            if( $uts['end'] >= $uts['start'] ) {
                $diff = $uts['end'] - $uts['start'];
                if( $days    = intval( ( floor( $diff/86400 ) ) ) ) $diff = $diff % 86400;
                if( $hours   = intval( ( floor( $diff/3600 ) ) )  ) $diff = $diff % 3600;
                if( $minutes = intval( ( floor( $diff/60 ) ) )    ) $diff = $diff % 60;
                $diff = intval( $diff );
                $diff = ( array('days'=>$days, 'hours'=>$hours, 'mins'=>$minutes, 'secs'=>$diff) );
                return $diff;
            }
        }
        return false;
    }
    
    
    /**
    * Function to calculate date or time difference. Returns an array or
    * false on error.
    * @param string $start
    * @param string $end
    * @return array
    */
    public static function startOfMonth( $month='', $year='', $format='Y-m-d H:i:s' ) {
        if( empty( $month ) ) { $month = date( 'm' ); }
        if( empty( $year  ) ) { $year  = date( 'Y' ); }
        return date( $format, mktime( 0, 0, 0, $month, 01, $year ) );
    }


    /**
    * Function to calculate date or time difference. Returns an array or
    * false on error.
    * @param string $start
    * @param string $end
    * @return array
    */
    public static function endOfMonth( $month='', $year='', $format='Y-m-d H:i:s' ) {
       if( empty( $month ) ) { $month = date( 'm' ); }
       if( empty( $year  ) ) { $year  = date( 'Y' ); }
       $result = strtotime( "{$year}-{$month}-01" );
       $result = strtotime( '-1 second', strtotime( '+1 month', $result ) );
       return date( $format, $result );
    }


    /**
    * Creates an array given a date range
    * @return mixed
    */
    public static function dateRangeArray( $start, $end ) {
        $range = array( );
        $start = !is_numeric( $start ) ? strtotime( $start ) : $start;
        $end   = !is_numeric( $end   ) ? strtotime( $end   ) : $end;

        do {
            $range[] = date('Y-m-d', $start);
            $start = strtotime("+ 1 day", $start);
        }
        while($start <= $end);
        return $range;
    }


    /**
    * Compares a date in given start and end range
    * @return bool
    */
    public static function inRange( $start, $end, $date ) {
      $start = date( 'Y-m-d', strtotime( $start ) );
      $end   = date( 'Y-m-d', strtotime( $end   ) );
      $date  = date( 'Y-m-d', strtotime( $date  ) );
      return (($date >= $start) && ($date <= $end));
    }


    /**
    * Output Since Time Ago Calculation
    * @param string $dateFrom
    * @param string $dateTo
    * @return string
    */
    public static function timeSince( $dateFrom, $format='', $dateTo=-1 ) {
        // Defaults and assume if 0 is passed in that
        // its an error rather than the epoch
        if( $dateTo == -1 ) { $dateTo = time( ); }
        $dateFrom = strtotime( $dateFrom );

        // Calculate the difference in seconds betweeen
        // the two timestamps
        $difference = $dateTo-$dateFrom;

        if( $difference < 60 ) {
            $difference = $difference == 0 ? 1 : $difference; // 0 second doesn't make sense.
            return ( $difference == 1 ) ? "$difference second ago" : "$difference seconds ago";
        }
        else if( $difference >= 60 && $difference < 60*60 ) {
            $difference = floor( $difference / 60);
            return ( $difference == 1 ) ? "$difference minute ago" : "$difference minutes ago";
        }
        else if( $difference >= 60*60 && $difference < 60*60*24 ) {
            $difference = floor( $difference / 60 / 60);
            return ( $difference == 1 ) ? "$difference hour ago" : "$difference hours ago";
        }
        else if( $difference >= 60*60*24 && $difference < 60*60*24*7 ) {
            $difference = floor( $difference / 60 / 60 / 24 );
            return ( $difference == 1 ) ? 'Yesterday at ' . date('h:i:a', $dateFrom) : date('l \a\t h:i:a', $dateFrom);
        }
        else if( $difference >= 60*60*24*7 && $difference < 60*60*24*365 ) {
            return date('F j \a\t h:i:a', $dateFrom);
        }
        else if( $difference >= 60*60*24*365 ) {
            return date('F j Y \a\t h:i:a', $dateFrom);
        }
    }


    /**
    * Output Since Time Ago Calculation(FULL Version) NOTE: Not in use in the Aurora System
    * This full version include output of Weeks, Years and Months ago.
    * @param string $dateFrom
    * @param string $dateTo
    * @return string
    */
    public static function timeSinceFull( $dateFrom, $dateTo=-1 ) {
        // Defaults and assume if 0 is passed in that
        // its an error rather than the epoch
        if( $dateTo == -1 ) { $dateTo = time(); }

        // Calculate the difference in seconds betweeen
        // the two timestamps
        $difference = $dateTo-$dateFrom;

        // If difference is less than 60 seconds,
        // seconds is a good interval of choice
        if( $difference < 60 ) { $interval = 's'; }
        // If difference is between 60 seconds and
        // 60 minutes, minutes is a good interval
        else if( $difference >= 60 && $difference < 60*60 ) {
            $interval = 'n';
        }
        // If difference is between 1 hour and 24 hours
        // hours is a good interval
        else if( $difference >= 60*60 && $difference < 60*60*24 ) {
            $interval = 'h';
        }
        // If difference is between 1 day and 7 days
        // days is a good interval
        elseif( $difference >= 60*60*24 && $difference < 60*60*24*7 ) {
            $interval = 'd';
        }
        // If difference is between 1 week and 30 days
        // weeks is a good interval
        else if( $difference >= 60*60*24*7 && $difference < 60*60*24*30 ) {
            $interval = 'ww';
        }
        // If difference is between 30 days and 365 days
        // months is a good interval, again, the same thing
        // applies, if the 29th February happens to exist
        // between your 2 dates, the function will return
        // the 'incorrect' value for a day
        else if( $difference >= 60*60*24*30 && $difference < 60*60*24*365 ) {
            $interval = 'm';
        }
        // If difference is greater than or equal to 365
        // days, return year. This will be incorrect if
        // for example, you call the function on the 28th April
        // 2008 passing in 29th April 2007. It will return
        // 1 year ago when in actual fact (yawn!) not quite
        // a year has gone by
        else if( $difference >= 60*60*24*365 ) { $interval = 'y'; }

        // Based on the interval, determine the
        // number of units between the two dates
        // From this point on, you would be hard
        // pushed telling the difference between
        // this function and DateDiff. If the $dateDiff
        // returned is 1, be sure to return the singular
        // of the unit, e.g. 'day' rather 'days'
        switch( $interval ) {
            case 'm':

            $monthsDiff = floor( $difference / 60 / 60 / 24 / 29 );
            while( mktime( date( 'H', $dateFrom ),
                   date( 'i', $dateFrom ),
                   date( 's', $dateFrom ),
                   date( 'n', $dateFrom )+( $monthsDiff ),
                   date( 'j', $dateTo ),
                   date( 'Y', $dateFrom) ) < $dateTo ) {
                $monthsDiff++;
            }
            $dateDiff = $monthsDiff;

            // We need this in here because it is possible
            // to have an 'm' interval and a months
            // difference of 12 because we are using 29 days
            // in a month
            if( $dateDiff == 12 ) { $dateDiff--; }
            $res = ($dateDiff==1) ? "$dateDiff month ago" : "$dateDiff months ago";
            break;

            case 'y':
            $dateDiff = floor( $difference / 60 / 60 / 24 / 365);
            $res = ( $dateDiff == 1 ) ? "$dateDiff year ago" : "$dateDiff years ago";
            break;

            case 'd':
            $dateDiff = floor( $difference / 60 / 60 / 24);
            $res = ( $dateDiff == 1 ) ? 'Yesterday at ' : "$dateDiff days ago";
            break;

            case 'ww':
            $dateDiff = floor( $difference / 60 / 60 / 24 / 7 );
            $res = ( $dateDiff == 1 ) ? "$dateDiff week ago" : "$dateDiff weeks ago";
            break;

            case 'h':
            $dateDiff = floor( $difference / 60 / 60);
            $res = ( $dateDiff == 1 ) ? "$dateDiff hour ago" : "$dateDiff hours ago";
            break;

            case 'n':
            $dateDiff = floor( $difference / 60);
            $res = ( $dateDiff == 1 ) ? "$dateDiff minute ago" : "$dateDiff minutes ago";
            break;

            case 's':
            $dateDiff = $difference;
            $dateDiff = $dateDiff == 0 ? 1 : $dateDiff;
            $res = ( $dateDiff == 1 ) ? "$dateDiff second ago" : "$dateDiff seconds ago";
            break;
        }
        return $res;
    }
}
?>