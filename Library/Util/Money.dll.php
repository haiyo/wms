<?php
namespace Library\Util;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Friday, July 27, 2012
 * @version $Id: Money.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Money {


    /**
    * Money Constructor
    * @return void
    */
    function __construct( ) {
        //
    }
    
    
    /**
    * Extract content starting from a word
    * @param $string - Content
    * @param $start - str
    * @param $end - str
    * @return string
    */
    public static function format( $money ) {
        return str_replace('.00', '', number_format( $money,2 ) );
    }
}
?>