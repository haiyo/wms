<?php
namespace Library\Util;
use \Library\Interfaces\IFilter;
use \Library\Http\HttpRequest, \Library\Http\HttpResponse;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: FilterChain.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class FilterChain {


    // Properties
    protected $Filter;


    /**
    * FilterChain Constructor
    * @return void
    */
    function __construct( ) {
        $this->Filter = array( );
	}


    /**
    * Add filter to the chain
    * @return void
    */
    function addFilter( IFilter $Filter ) {
        $this->Filter[] = $Filter;
	}


    /**
    * Add filter to the chain
    * @return void
    */
    public function doFilter( HttpRequest $Request, HttpResponse $Response ) {
        $Filter = array_shift( $this->Filter );
        if( !$Filter ) return;
        $Filter->doFilter( $Request, $Response, $this );
    }
}
?>