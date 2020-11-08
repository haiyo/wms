<?php
namespace Library\Helper\Markaxis;
use \Library\Interfaces\IListHelper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: SourceTypeHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class SourceTypeHelper implements IListHelper {


    // Properties


    /**
     * SourceTypeHelper Constructor
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
        return array( 1, 4, 5, 6, 9 );
    }


    /**
     * Return List with Translation
     * @static
     * @return mixed
     */
    public static function getL10nList( ) {
        return array( 1 => 'Mindef',
                      4 => 'Government Department',
                      5 => 'Statutory Board',
                      6 => 'Private Sector',
                      9 => 'Others' );
    }
}
?>