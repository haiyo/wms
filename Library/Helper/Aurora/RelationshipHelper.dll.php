<?php
namespace Library\Helper\Aurora;
use \IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: RelationshipHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RelationshipHelper implements IListHelper {


    // Properties


    /**
     * RelationshipHelper Constructor
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
        return array( );
    }


    /**
     * Return List with Translation
     * @static
     * @return mixed
     */
    public static function getL10nList( ) {
        return array( 'Mother' => 'Mother',
                      'Father'   => 'Father',
                      'Wife'  => 'Wife',
                      'Husband' => 'Husband',
                      'Son'    => 'Son',
                      'Daughter' => 'Daughter',
                      'Sister' => 'Sister',
                      'Brother' => 'Brother',
                      'Uncle' => 'Uncle',
                      'Auntie' => 'Auntie',
                      'Others' => 'Others' );
    }
}
?>