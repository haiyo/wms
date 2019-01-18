<?php
namespace Library\Interfaces;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: IValidator.dll.php, v 2.0 Exp $
 * @desc Validator Interface Implementation
*/

interface IValidator {


    /**
    * Provide validation algorithm
    * @returns bool
    */
    public function validate( );
}
?>