<?php
namespace Library\Exception\Aurora;
use \Library\Exception\Exceptions;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: NoPermissionException.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NoPermissionException extends Exceptions {


    /**
    * NoPermissionException Constructor
    * @return void
    */
    function __construct( $string='' ) {
        parent::__construct( 'No Permission To Perform Operation. ' . $string );
    }
}
?>