<?php
namespace Library\Helper\Markaxis;
use \Library\Interfaces\IListHelper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: IrasPaymentTypeHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class IrasPaymentTypeHelper implements IListHelper {


    // Properties


    /**
     * IrasPaymentTypeHelper Constructor
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
        return array( '08' );
    }


    /**
     * Return List with Translation
     * @static
     * @return mixed
     */
    public static function getL10nList( ) {
        return array( '08' => 'Salary Data' );
    }
}
?>