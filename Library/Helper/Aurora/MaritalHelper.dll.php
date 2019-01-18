<?php
namespace Library\Helper\Aurora;
use \Library\Runtime\Registry, \Library\Interfaces\IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: MaritalHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class MaritalHelper implements IListHelper {


    // Properties


    /**
    * MaritalHelper Constructor
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
        return array( 'single', 'married', 'divorced', 'widow' );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Aurora/Helper/MaritalRes');

        return array( 'single'   => 'Single',
                      'married'  => 'Married',
                      'divorced' => 'Divorced',
                      'widow'    => 'Widow' );
	}
}
?>