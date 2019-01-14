<?php

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: IsEmpty.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class IsEmpty implements IValidator {


    // Properties
    protected $str;


    /**
    * IsEmpty Constructor
    * @return void
    */
    function __construct( $str ) {
        $this->str = $str;
	}


    /**
    * Check If str Is Empty
    * @return bool
    */
    public function validate( ) {
    	return strlen( preg_replace( '/[\s]/', '', $this->str ) ) == 0 ? false : true;
    }
}
?>