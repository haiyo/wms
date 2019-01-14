<?php
namespace Library\Exception;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: Exceptions.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Exceptions extends \Exception {

    
    // Properties
    protected $dateTime;
    protected $errorLogName;


    /**
    * Constructor - Preparing attributes to start logging errors
    * @returns void
    */
    public function __construct( $message, $code=0, $file='', $line='' ) {
        parent::__construct( $message, $code );

        // Set Parent Properties
        $this->file = $file;
        $this->line = $line;
        $this->dateTime = date( 'd/M/Y H:i:s' );
        $this->errorLogName = 'errorlog.php';
    }


    /**
     * Gather all information together
     * @returns string
     */
    public function setErrorLogName( $filename ) {
        $this->errorLogName = $filename;
    }


    /**
    * Gather all information together
    * @returns string
    */
    public function toString( ) {
    	$line  = '[' . $this->dateTime . '] ' . $this->message;
        $line .= $this->file != '' ? ' | ' . $this->file : '';
        $line .= $this->line != '' ? ' | ' . $this->line : '';
        $line .= chr(13);
        return $line;
    }
    

    /**
    * Record error to log file
    * @returns void
    */
    public function record( $errorLogFilename='errorlog.php' ) {
        if( defined( 'LOG_DIR' ) ) {
            File::write( LOG_DIR . $errorLogFilename, $this->toString( ), FILE_APPEND );
        }
    }


    /**
    * Send error to mail
    * @returns void
    */
    public function mailErrorTo( $email ) {
        Package::import( LIB . 'Util/Mail.dll.php' );
        $Mail = new Mail( $email, SYSTEM_EMAIL, 'Error Reporting From ' . SITENAME,
                          $this->toString( ), SYSTEM_EMAIL );
        $Mail->sendMail( );
    }


    /**
     * Returns information on Caller
     * @returns void
     */
    public static function getCaller( ) {
        $caller = debug_backtrace();
        $caller = $caller[2];
        $r = $caller['function'] . '()';
        if (isset($caller['class'])) {
            $r .= ' in ' . $caller['class'];
        }
        if (isset($caller['object'])) {
            $r .= ' (' . get_class($caller['object']) . ')';
        }
        return $r;
    }


    /**
    * Send error to mail
    * @returns void
    */
    public function debugTrace( ) {
        $str = '';
        $trace = debug_backtrace( );
        array_shift( $trace );
        array_shift( $trace );

        while( list( $key, $value ) = each( $trace ) ) {
            $str .= '#' . $key . ' ';
            if( isset( $value['file']     ) ) $str .= $value['file'];
            if( isset( $value['line']     ) ) $str .= '(' . $value['line'] . '): ';
            if( isset( $value['class']    ) ) $str .= $value['class'];
            if( isset( $value['type']     ) ) $str .= $value['type'];
            if( isset( $value['function'] ) ) $str .= $value['function'] . '(';

            if( isset( $value['args'] ) && is_array( $value['args'] ) ) {
                while( list( $key1, $value1 ) = each( $value['args'] ) ) {
                    $quote = '';
                    if( !is_array( $value1 ) && !is_object( $value1 ) ) {
                        $quote = '\'';
                    }
                    else if( is_object( $value1 ) ) {
                        $value1 = '';
                    }
                    else if( is_array( $value1 ) ) {
                        continue;
                    }
                    $str .= $quote . $value1;
                    if( $quote ) $str .= '\', ';
                }
            }

            if( substr( $str, -2 ) == ', ' ) {
            	$str = substr( $str, 0, -2 );
            }
            $str .= ')<br />';
        }
        return $str;
    }


    /**
    * Record error to log file
    * @returns void
    */
    public function toScreen( ) {
        echo '<pre>' . $this->debugTrace( ) . '</pre>';
    }
}
?>