<?php
namespace Library\Helper\Aurora;
use \Library\Runtime\Registry, \Library\Interfaces\IListHelper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: IDTypeHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class IDTypeHelper implements IListHelper {


    // Properties


    /**
    * IDTypeHelper Constructor
    * @return void
    */
    function __construct( ) {
        //
	}


    /**
    * Return List
    * @static
    * @return mixed
    */
    public static function getList( ) {
        return array( 1, 2, 3, 4, 5, 6 );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        return array( 1 => 'NRIC',
                      2 => 'FIN (Foreign Identification No.)',
                      3 => 'Immigration File Ref No.',
                      4 => 'Work Permit No.',
                      5 => 'Malaysian I/C',
                      6 => 'Passport No.',
            );
	}
}
?>