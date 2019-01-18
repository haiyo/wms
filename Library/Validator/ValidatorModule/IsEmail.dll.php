<?php
namespace Library\Validator\ValidatorModule;

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
        //if( !preg_match( '/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/', $this->email ) ) {
        if( !preg_match("/^[^@]+@[^@]+\.[a-z]{2,6}$/i", $this->email ) ) {
            return false;
        }
        return true;
    }
}
?>