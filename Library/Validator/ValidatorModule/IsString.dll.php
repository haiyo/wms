<?php
namespace Library\Validator\ValidatorModule;
use \Library\Interfaces\IValidator;

/**
 * Check if String contains only valid characters.
 * Allowed valid characters: alphanumeric, space and the following _-&()*"'.,:
 *
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: IsString.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
*/

class IsString implements IValidator {


    // Properties
    protected $str;


    /**
    * IsString Constructor
    * @return void
    */
    function __construct( $str ) {
        $this->str = $str;
    }


    /**
    * Validation Algorithm
    * @returns bool
    */
    public function validate( ) {
        if( !preg_match( '/^[a-zA-Z0-9_\s-&()*"\':.,]+$/i', $this->str ) ) {
            return false;
        }
        return true;
    }
}
?>