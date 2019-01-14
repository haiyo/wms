<?php
namespace Library\Helper\Aurora;
use \Library\Runtime\Registry, \IListHelper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: GenderHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class GenderHelper implements IListHelper {


    // Properties


    /**
    * GenderHelper Constructor
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
        return array( 'm', 'f' );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Aurora/Helper/GenderRes');

        return array( 'm' => $L10n->getContents('LANG_MALE'),
                      'f' => $L10n->getContents('LANG_FEMALE') );
	}
}
?>