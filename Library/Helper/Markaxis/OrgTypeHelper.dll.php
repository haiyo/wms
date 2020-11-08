<?php
namespace Library\Helper\Markaxis;
use \Library\Interfaces\IListHelper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: OrgTypeHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class OrgTypeHelper implements IListHelper {


    // Properties


    /**
     * OrgTypeHelper Constructor
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
        return array( 7, 8, 'A', 'I', 'U' );
    }


    /**
     * Return List with Translation
     * @static
     * @return mixed
     */
    public static function getL10nList( ) {
        return array( 7 => 'UEN - Business Registration (ACRA)',
                      8 => 'UEN - Local Company Registration (ACRA)',
                     'A' => 'ASGD - Tax Reference No. (IRAS)',
                     'I' => 'ITR - Income Tax Reference No. (IRAS)',
                     'U' => 'UENO - Unique Entity No. (Foreign Company)' );
    }
}
?>