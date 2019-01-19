<?php
namespace Library\Interfaces;
use \Library\Util\FilterChain;
use \Library\Http\HttpRequest, \Library\Http\HttpResponse;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: IFilter.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

interface IFilter {


    public function doFilter( HttpRequest $Request, HttpResponse $Response, FilterChain $FilterChain );
}
?>