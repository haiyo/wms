<?php
namespace Library\Helper\Aurora;
use \IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: PageLayoutHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PageLayoutHelper implements IListHelper {


    // Properties


    /**
    * PageLayoutHelper Constructor
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
        return array( 'left', 'right', 'full', 'two', 'three', 'half',
                      'left3', 'right3', 'left4', 'right4' );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        //
	}
}
?>