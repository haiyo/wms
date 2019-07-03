<?php
namespace Library\Util;
use \Library\Exception\FileNotFoundException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: XML.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
*/

class XML {


    protected $cache;
    protected $file;
    protected $data;

    
    /**
    * User Constructor
    * @returns void
    */
    function __construct( ) {
        $this->file = $this->data = array( );
    }


    /**
    * User Constructor
    * @return mixed
    */
    public function load( $file ) {
        if( is_file( $file ) && !isset( $this->cache[$file] ) ) {
            $this->cache[$file] = simplexml_load_file( $file, 'SimpleXMLElement', LIBXML_NOCDATA );
            return $this->cache[$file];
        }
        throw( new FileNotFoundException( 'Failed to open ' . $file . '.' ) );
    }
}
?>