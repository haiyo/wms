<?php
namespace Library\Helper\Aurora;
use \Library\Runtime\Registry, \Library\Interfaces\IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: bfEnforceHelper.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class bfEnforceHelper implements IListHelper {


    // Properties


    /**
    * bfEnforceHelper Constructor
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
        return array( 0, 5, 10, 15, 20, 25, 30 );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Aurora/Config/BFLoginRes');

        // Just do normal str_replace since we don't need plural rules
        return array( 0  => $L10n->getContents('LANG_NO_ACTION'),
                      5  => str_replace( '{n}', 5,  $L10n->getContents('LANG_BLOCK_IP_FOR_N') ),
                      10 => str_replace( '{n}', 10, $L10n->getContents('LANG_BLOCK_IP_FOR_N') ),
                      15 => str_replace( '{n}', 15, $L10n->getContents('LANG_BLOCK_IP_FOR_N') ),
                      20 => str_replace( '{n}', 20, $L10n->getContents('LANG_BLOCK_IP_FOR_N') ),
                      25 => str_replace( '{n}', 25, $L10n->getContents('LANG_BLOCK_IP_FOR_N') ),
                      30 => str_replace( '{n}', 30, $L10n->getContents('LANG_BLOCK_IP_FOR_N') ) );
	}
}
?>