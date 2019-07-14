<?php
use \Library\IO\File;

/**
 * Auto Load Files
 *
 * Note that AutoLoad only supports common directories. The load method will stop
 * once a file is found in the following respective order:
 * - Exception (Detects the word "Exception" For e.g: <b>Exception</b>PageLogger)
 * - Interface (Detects the character "I" For e.g: <b>I</b>Page)
 * - Helper (If any of the above fail, Aurora will look for the file in the Helper folder)
 *
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: AutoLoad.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

new AutoLoad( );

class AutoLoad {


    // Properties


    /**
    * AutoLoad Constructor
    * @return void
    */
    public function __construct( ) {
        spl_autoload_register( array( $this, 'load' ) );
    }


    /**
    * Load file from specific folder by the following respectively order:
    * - Exception (Detects the word "Exception" For e.g: PageLogger<b>Exception</b>)
    * - Interface (Detects the character "I" followed by one Capitalize character. For e.g: <b>IP</b>age)
    * - Helper (Detects the word "Helper" For e.g: Page<b>Helper</b>)
    * @return void
    */
    public function load( $className ) {
        if( preg_match( '/^[a-zA-Z0-9_\-\\\]+$/', $className ) ) {
            // Convert path to windows/linux compatible
            $className = str_replace( '\\', '/', $className );

            try {
                if( substr( $className, -7 ) == 'Control' ) {
                    File::import( CONTROL . $className . '.class.php' );
                    return;
                }
                if( substr( $className, -5 ) == 'Model' ) {
                    File::import( MODEL . $className . '.class.php' );
                    return;
                }
                if( substr( $className, -4 ) == 'View' ) {
                    File::import( VIEW . $className . '.class.php' );
                    return;
                }
                if( substr( $className, -3 ) == 'Res' ) {
                    File::import( LANG . $className . '.lang.php' );
                    return;
                }

                if( is_file( APP . $className . '.class.php' ) ) {
                    File::import( APP . $className . '.class.php' );
                    return;
                }
                if( strstr( $className, 'Exception' ) ) {
                    File::import( ROOT . $className . '.dll.php' );
                    return;
                }
                // Interface
                if( preg_match( '/^I[A-Z]{1}[a-zA-Z]+$/', $className ) ) {
                    File::import( INT . $className . '.dll.php' );
                    return;
                }
                if( substr( $className, -6 ) == 'Helper' ) {
                    File::import( ROOT . $className . '.dll.php' );
                    return;
                }
                // If everything else failed...
                if( is_file( DAO . $className . '.class.php' ) ) {
                    File::import( DAO . $className . '.class.php' );
                    return;
                }
                if( is_file( ROOT . $className . '.dll.php' ) ) {
                    File::import( ROOT . $className . '.dll.php' );
                    return;
                }
                if( is_file( ROOT . $className . '.class.php' ) ) {
                    File::import( ROOT . $className . '.class.php' );
                    return;
                }
                if( is_file( LANG . $className . '.lang.php' ) ) {
                    File::import( LANG . $className . '.lang.php' );
                    return;
                }
            }
            catch( \Library\Exception\FileNotFoundException $e ) {
                $e->record( );
                $e->toScreen( );
            }
        }
    }
}
?>