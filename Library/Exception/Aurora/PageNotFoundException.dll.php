<?php
namespace Library\Exception\Aurora;
use \Library\Exception\Exceptions;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PageNotFoundException.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PageNotFoundException extends Exceptions {


    /**
     * PageNotFoundException Constructor
     * @return void
     */
    function __construct( $errCode, HttpRequest $Request=NULL ) {
        parent::__construct( $errCode . ' - ' . implode(',', $_SERVER)  );
    }
}
?>