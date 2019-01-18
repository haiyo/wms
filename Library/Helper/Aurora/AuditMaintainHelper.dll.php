<?php
namespace Library\Helper\Aurora;
use \Library\Runtime\Registry, \Library\Interfaces\IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: AuditMaintainHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AuditMaintainHelper implements IListHelper {


    // Properties


    /**
    * AuditMaintainHelper Constructor
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
        return array( 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12 );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Aurora/Helper/AuditMaintainRes');

        return array( 0  => $L10n->getContents('LANG_NEVER_PURGE'),
                      1  => $L10n->getText('LANG_PURGE_N_OLD', 1 ),
                      2  => $L10n->getText('LANG_PURGE_N_OLD', 2 ),
                      3  => $L10n->getText('LANG_PURGE_N_OLD', 3 ),
                      4  => $L10n->getText('LANG_PURGE_N_OLD', 4 ),
                      5  => $L10n->getText('LANG_PURGE_N_OLD', 5 ),
                      6  => $L10n->getText('LANG_PURGE_N_OLD', 6 ),
                      7  => $L10n->getText('LANG_PURGE_N_OLD', 7 ),
                      8  => $L10n->getText('LANG_PURGE_N_OLD', 8 ),
                      9  => $L10n->getText('LANG_PURGE_N_OLD', 9 ),
                      10 => $L10n->getText('LANG_PURGE_N_OLD', 10 ),
                      11 => $L10n->getText('LANG_PURGE_N_OLD', 11 ),
                      12 => $L10n->getText('LANG_PURGE_N_OLD', 12 ) );
	}
}
?>