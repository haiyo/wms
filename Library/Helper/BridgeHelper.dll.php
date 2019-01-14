<?php
namespace Library\Helper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: BridgeHelper.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class BridgeHelper {


    // Properties
    protected $extensions;


    /**
    * BridgeHelper Constructor
    * @return void
    */
    function __construct( ) {

        $this->extensions = array( );
	}


    /**
    * Add New Object Extension
    * @return void
    */
    public function addExtension( $Extension ) {

        $this->extensions[] = $Extension;
        $this->extensions   = array_reverse( $this->extensions );
	}


    /**
    * Try to invoke runtime methods.
    * @throw Exceptions
    * @return mixed
    */
    public function __call( $method, $args )
    {
        foreach( $this->extensions as $ext )
        {
            if( method_exists( $ext, $method ) ) {
                return $ext->$method( $args );
            }
        }
        throw new \Exceptions( "This Method {$method} doesn't exists" );
    }
}
?>