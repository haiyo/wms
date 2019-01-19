<?php
namespace Library\Helper\Markaxis;
use \Library\Runtime\Registry, \Library\Interfaces\IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LogoHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LogoHelper implements IListHelper {


    // Properties


    /**
    * LogoHelper Constructor
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
        return array( '0', '1', '2' );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Markaxis/CRM/Quotation/Helper/LogoRes');

        return array( '0'  => $L10n->getContents('LANG_USE_EXISTING_LOGO'),
                      '1'  => $L10n->getContents('LANG_UPLOAD_NEW_LOGO'),
                      '2'  => $L10n->getContents('LANG_NO_LOGO') );
	}
}
?>