<?php
namespace Library\Helper\Aurora;
use \Library\Runtime\Registry, \IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: LogMaintainHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LogMaintainHelper implements IListHelper {


    // Properties


    /**
    * LogMaintainHelper Constructor
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
        return array( '100', '200', '300', '400', '500', '1024', '2048' );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Aurora/Helper/LogMaintainRes');

        return array( '100'  => $L10n->getContents('LANG_LOG_100'),
                      '200'  => $L10n->getContents('LANG_LOG_200'),
                      '300'  => $L10n->getContents('LANG_LOG_300'),
                      '400'  => $L10n->getContents('LANG_LOG_400'),
                      '500'  => $L10n->getContents('LANG_LOG_500'),
                      '1024' => $L10n->getContents('LANG_LOG_1024'),
                      '2048' => $L10n->getContents('LANG_LOG_2048') );
	}
}
?>