<?php
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: Caching.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Caching {
    
    
    // Properties
    protected $dir;
    protected $cacheLen  = 30;    // length of caching, 30 units.
    protected $timeUnit  = 'min'; // time unit
    protected $timeUnitArr = array( 'sec'  => 1,    'min' => 60,
                                    'hour' => 3600, 'day' => 86400 );


    /**
    * Caching Constructor
    * @return void
    */
    function __construct( $dir ) {
        if( !is_dir( $dir ) ) {
            die( 'Invalid cache directory. Please make sure folder is created and readable.' );
        }
        $this->dir = $dir;
    }
    

    /**
    * Set Cache time length
    * @return int
    */
    public function setLen( $len ) {
        $this->cacheLen = (int)$len;
    }


    /**
    * Read cache file
    * @return mixed
    */
    public function read( $filename ) {
        try {
            $File = new File( );
            return $File->read( $this->dir . $filename . '.cache' );
        }
        catch( FileNotFoundException $e ) {
            return false;
        }
   }


    /**
    * Check if cache is valid in terms of cache durations
    * @return bool
    */
    public function isValid( $filename ) {
        try {
            $File = new File( );
            $val  = $File->read( $this->dir . $filename . '.cntrl' );
            $val  = explode( ':', $val );
            return $this->timeDiff( time( ), $val[0] ) <= $val[1];
        }
        catch( FileNotFoundException $e ) {
            return false;
        }
    }
    
    
    /**
    * Save cache file
    * @return void
    */
    public function save( $filename, $content ) {
        if( !is_writable( $this->dir ) ) {
            die( 'Unable to write cache to ' . $this->dir . '. Please check permission!' );
        }
        
        // write the contents
        file_put_contents( $this->dir . $filename . '.cache', $content );

        // write the cache control file
        file_put_contents( $this->dir . $filename . '.cntrl', time( ) . ':' . $this->cacheLen );
    }
    

   /**
    * Return time difference
    * @return int
    */
    private function timeDiff( $end, $start ) {
        $factor = $this->timeUnitArr[$this->timeUnit];
        return intval( ( $end - $start )/$factor );
    }
}
?>