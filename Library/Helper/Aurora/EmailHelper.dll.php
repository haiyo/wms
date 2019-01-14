<?php
namespace Library\Helper\Aurora;
use \Library\Runtime\Registry, \IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: EmailHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EmailHelper implements IListHelper {


    // Properties


    /**
    * EmailHelper Constructor
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
        $L10n = $i18n->loadLanguage('Aurora/Helper/EmailRes');

        return array( 0 => $L10n->getContents('LANG_PERSONAL'),
                      1 => $L10n->getContents('LANG_WORK'),
                      2 => $L10n->getContents('LANG_MSN'),
                      3 => $L10n->getContents('LANG_SKYPE'),
                      4 => $L10n->getContents('LANG_GTALK'),
                      5 => $L10n->getContents('LANG_YMSG'),
                      6 => $L10n->getContents('LANG_OTHER') );
	}
}
?>