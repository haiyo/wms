<?php
namespace Library\Exception\PHPMailer;
use \Library\Exception\Exceptions;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: PHPMailerException.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PHPMailerException extends Exceptions {


    /**
    * AuthLoginException Constructor
    * @return void
    */
    function __construct( $errMsg ) {
        parent::__construct( $errMsg );
    }
}
?>