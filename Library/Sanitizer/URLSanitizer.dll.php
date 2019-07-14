<?php

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: URLSanitizer.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class URLSanitizer {


    // Properties


    /**
    * URLSanitizer Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * Return sanitize string
    * Returns a sanitized string
    * @return string
    */
    public static function sanitize( $string, $lowercase=false, $removeNonAlpha=false ) {
        $strip = array("~", "`", "!", "@", "$", "^", "*", "(", ")", "[", "{", "]",
                       "}", "\\", "|", ";", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;",
                       "&#8212;", "â€”", "â€“", ",", "<", ">", );
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($removeNonAlpha) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
        return ($lowercase) ? (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') : strtolower($clean) : $clean;
    }
}
?>