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

            if( $className == 'Model' ) {
                File::import( MODEL . 'Model.class.php' );
                return;
            }
            if( $className == 'Aurora/AuroraView' ) {
                File::import( VIEW . 'Aurora/AuroraView.class.php' );
                return;
            }
            if( $className == 'View' ) {
                File::import( VIEW . 'View.class.php' );
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
            //if( strstr( $className, 'Helper' ) ) {
            if( substr( $className, -6 ) == 'Helper' ) {
                File::import( ROOT . $className . '.dll.php' );
                return;
            }
        }
    }
}
?>