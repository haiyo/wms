<?php
namespace Library\Validator\ValidatorModule;
use \Library\Interfaces\IValidator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: IsEmail.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
*/

class IsEmail implements IValidator {


    // Properties
    protected $email;


    /**
    * IsEmail Constructor
    * @return void
    */
    function __construct( $email ) {
        $this->email = $email;
    }


    /**
    * Validation Algorithm
    * @return bool
    */
    public function validate( ) {
        // Remove all illegal characters from email
        $this->email = filter_var( $this->email,FILTER_SANITIZE_EMAIL );

        if( !filter_var( $this->email,FILTER_VALIDATE_EMAIL ) ) {
            return false;
        }
        return true;
    }
}
?>