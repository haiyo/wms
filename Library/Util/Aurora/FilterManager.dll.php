<?php
namespace Library\Util\Aurora;
use \Library\Util\FilterChain, \Library\Util\XML, \Library\Http\HttpRequest, \Library\Http\HttpResponse;
use \Library\Exception\FileNotFoundException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: FilterManager.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class FilterManager {


    // Properties
    protected $FilterChain;


    /**
    * FilterManager Constructor
    * @return void
    */
    function __construct( ) {
        $this->FilterChain = new FilterChain;
	}


    /**
    * Instantiate Filters and add to the FilterChain
    * @return void
    */
    public function processFilter( $xmlFile ) {
        try {
            // Start loading XML for Filters information
            $XML = new XML( );
            $XMLElement = $XML->load( $xmlFile );
            $sizeof = sizeof( $XMLElement->filter );

            for( $i=0; $i<$sizeof; $i++ ) {
                $className = str_replace( '/', '\\', (string)$XMLElement->filter[$i] );
                //echo $className . '<br>';
                $this->FilterChain->addFilter( new $className( ) );
            }
        }
        catch( FileNotFoundException $e ) {
            $e->record( );
        }
    }


    /**
    * Execute Filter Chain
    * @return void
    */
    public function execute( HttpRequest $Request, HttpResponse $Response ) {
        $this->FilterChain->doFilter( $Request, $Response );
    }
}
?>