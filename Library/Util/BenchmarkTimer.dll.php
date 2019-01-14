<?php

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: BenchmarkTimer.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class BenchmarkTimer {


    // Properties
    private static $start;


    /**
    * BenchmarkTimer Constructor
    * @return void
    */
    function __construct( ) {
        //
    }
    
    
    /**
    * Start Timer
    * @return void
    */
    public static function start( $stop=false ) {
        list( $usec, $sec ) = explode( ' ', microtime( ) );
        $timer = ( (float)$usec + (float)$sec );

        if( !$stop ) {
            return self::$start = $timer;
        }
        return $timer;
    }

   
    /**
    * Stop Timer
    * @return int
    */
    public static function stop( ) {
        return number_format( substr( self::start( true )-self::$start, 0, 5 ), 2 );
    }
}
?>