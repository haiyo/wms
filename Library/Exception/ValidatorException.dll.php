<?php
namespace Library\Exception;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ValidatorException.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ValidatorException extends Exceptions {


    // Properties
    protected $moduleName;


    /**
    * ValidatorException Constructor
    * @return void
    */
    function __construct( $moduleName ) {
        $this->moduleName = $moduleName;
	}


    /**
    * Return module name that causes error
    * @return str
    */
    public function getModuleName( ) {
        return $this->moduleName;
	}
}
?>