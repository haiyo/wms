<?php

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: FileNameSanitizer.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class FileNameSanitizer {


    // Properties


    /**
    * FileNameSanitizer Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * Sanitizes a filename replacing whitespace with dashes
    *
    * Removes special characters that are illegal in filenames on certain
    * operating systems and special characters requiring special escaping
    * to manipulate at the command line. Replaces spaces and consecutive
    * dashes with a single dash. Trim period, dash and underscore from beginning
    * and end of filename.
    *
    * @param string $filename The filename to be sanitized
    * @return string The sanitized filename
    */
    public static function sanitize( $filename ) {
        $special_chars = array( "?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'",
                                "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{",
                                "}", "~" );

        $filename = str_replace($special_chars, '', $filename);
        $filename = preg_replace('/[\s-]+/', '-', $filename);
        return trim($filename, '.-_');
    }
}
?>