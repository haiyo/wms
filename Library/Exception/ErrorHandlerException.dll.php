<?php
namespace Library\Exception;
use \Exception;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ErrorHandlerException.dll.php, v 2.0 Exp $
 * @desc Abstract Error Handler Exception
 * Registers Itself as a PHP Error Handler and proceeds to convert all
 * native "old school" PHP errors into new PHP5 Exceptions.
 */

abstract class ErrorHandlerException {
    
    
    /**
    * Encapsulates set_error_handler( )
    */
    public static function init( ) {
        set_error_handler( array( '\\Library\\Exception\\ErrorHandlerException', 'handleError' ) );
    }

    
    /**
    * Encapsulates restore_error_handler( )
    */
    public static function unInit( ) {
        restore_error_handler( );
    }


    /**
    * Handles PHP Errors
    */
    public static function handleError( $errno, $errstr, $errfile, $errline, $errcontext ) {
        try {
            throw new Exception( $errstr, $errno );
        }
        catch( Exception $e ) {
            die( $e->getMessage( ) );
        }
    }
}
?>