<?php
namespace Library\Helper\Aurora;
use \Library\Runtime\Registry, \Library\Interfaces\IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: CacheTimeHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CacheTimeHelper implements IListHelper {


    // Properties


    /**
    * CacheTimeHelper Constructor
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
        return array( '0', '-1', '1', '2', '3', '4', '5' );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Aurora/Helper/CacheTimeRes');

        $langRefresh = $L10n->getContents('LANG_REFRESH_CACHE');

        return array( '0'  => $L10n->getContents('LANG_NEVER'),
                      '-1' => $langRefresh . $L10n->getContents('LANG_IF_CHANGES'),
                      '1'  => $langRefresh . $L10n->getText('LANG_EVERY_N_SECOND', 1 ),
                      '2'  => $langRefresh . $L10n->getText('LANG_EVERY_N_SECOND', 2 ),
                      '3'  => $langRefresh . $L10n->getText('LANG_EVERY_N_SECOND', 3 ),
                      '4'  => $langRefresh . $L10n->getText('LANG_EVERY_N_SECOND', 4 ),
                      '5'  => $langRefresh . $L10n->getText('LANG_EVERY_N_SECOND', 5 ) );
	}
}
?>