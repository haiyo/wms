<?php
namespace Library\Helper\Aurora;
use \Library\Runtime\Registry, \IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: SMTPConnectHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class SMTPConnectHelper implements IListHelper {


    // Properties


    /**
    * SMTPConnectHelper Constructor
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
        return array( '', 'tls', 'ssl' );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Aurora/Helper/SMTPConnectionRes');

        return array( '' => $L10n->getContents('LANG_NONE'),
                      'tls' => $L10n->getContents('LANG_TLS'),
                      'ssl' => $L10n->getContents('LANG_SSL') );
	}
}
?>