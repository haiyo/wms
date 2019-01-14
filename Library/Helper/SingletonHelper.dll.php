<?php
namespace Library\Helper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: SingletonHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

abstract class SingletonHelper {


    // Properties


    /**
    * SingletonHelper Constructor
    * @return void
    */
    protected function __construct( ) {
        //
	}


    /**
    * Return Class Instance
    * @return Obj
    */
    final public static function getInstance( ) {
        try {
            static $instance = array( );
            $className = get_called_class( );
            if( !isset( $instance[$className] ) ) {
                $instance[$className] = new $className( );
            }
            return $instance[$className];
        }
        catch( \Exceptions $e ) {
            $e->record( );
        }
    }


    /**
    * Magic __clone to prevent classes from cloning an instance
    * @return void
    */
    final private function __clone( ) { }
}
?>