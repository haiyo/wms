<?php
namespace Library\Helper\Aurora;
use \Library\Runtime\Registry, \IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: PhoneHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PhoneHelper implements IListHelper {


    // Properties


    /**
    * PhoneHelper Constructor
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
        return array( 0, 1, 2, 3 );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Aurora/Helper/PhoneRes');

        return array( 0 => $L10n->getContents('LANG_WORK'),
                      1 => $L10n->getContents('LANG_MOBILE'),
                      2 => $L10n->getContents('LANG_HOME'),
                      3 => $L10n->getContents('LANG_FAX'),
                      4 => $L10n->getContents('LANG_OTHER') );
	}
}
?>