<?php
namespace Library\Helper\Aurora;
use \Library\Runtime\Registry, \Library\Interfaces\IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: LoggingHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LoggingHelper implements IListHelper {


    // Properties


    /**
    * LoggingHelper Constructor
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
        return array( 'log', 'logSend', 'logPrint' );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Aurora/Helper/LoggingRes');

        return array( 'log'      => $L10n->getContents('LANG_LOG_FILE'),
                      'logSend'  => $L10n->getContents('LANG_LOG_SEND'),
                      'logPrint' => $L10n->getContents('LANG_PRINT_ERROR') );
	}
}
?>