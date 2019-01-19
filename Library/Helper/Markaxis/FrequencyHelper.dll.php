<?php
namespace Library\Helper\Markaxis;
use \Library\Runtime\Registry, \Library\Interfaces\IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: FrequencyHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class FrequencyHelper implements IListHelper {


    // Properties


    /**
    * FrequencyHelper Constructor
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
        return array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
                      11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
                      21, 22, 23, 24, 25, 26, 27, 28, 29, 30 );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Markaxis/SEO/ClientList/Helper/FrequencyRes');

        return array( 1  => $L10n->getText('LANG_EMAIL_EVERY', 1, 1 ),
                      2  => $L10n->getText('LANG_EMAIL_EVERY', 2, 2 ),
                      3  => $L10n->getText('LANG_EMAIL_EVERY', 3, 3 ),
                      4  => $L10n->getText('LANG_EMAIL_EVERY', 4, 4 ),
                      5  => $L10n->getText('LANG_EMAIL_EVERY', 5, 5 ),
                      6  => $L10n->getText('LANG_EMAIL_EVERY', 6, 6 ),
                      7  => $L10n->getText('LANG_EMAIL_EVERY', 7, 7 ),
                      8  => $L10n->getText('LANG_EMAIL_EVERY', 8, 8 ),
                      9  => $L10n->getText('LANG_EMAIL_EVERY', 9, 9 ),
                      10 => $L10n->getText('LANG_EMAIL_EVERY', 10, 10 ),
                      11 => $L10n->getText('LANG_EMAIL_EVERY', 11, 11 ),
                      12 => $L10n->getText('LANG_EMAIL_EVERY', 12, 12 ),
                      13 => $L10n->getText('LANG_EMAIL_EVERY', 13, 13 ),
                      14 => $L10n->getText('LANG_EMAIL_EVERY', 14, 14 ),
                      15 => $L10n->getText('LANG_EMAIL_EVERY', 15, 15 ),
                      16 => $L10n->getText('LANG_EMAIL_EVERY', 16, 16 ),
                      17 => $L10n->getText('LANG_EMAIL_EVERY', 17, 17 ),
                      18 => $L10n->getText('LANG_EMAIL_EVERY', 18, 18 ),
                      19 => $L10n->getText('LANG_EMAIL_EVERY', 19, 19 ),
                      20 => $L10n->getText('LANG_EMAIL_EVERY', 20, 20 ),
                      21 => $L10n->getText('LANG_EMAIL_EVERY', 21, 21 ),
                      22 => $L10n->getText('LANG_EMAIL_EVERY', 22, 22 ),
                      23 => $L10n->getText('LANG_EMAIL_EVERY', 23, 23 ),
                      24 => $L10n->getText('LANG_EMAIL_EVERY', 24, 24 ),
                      25 => $L10n->getText('LANG_EMAIL_EVERY', 25, 25 ),
                      26 => $L10n->getText('LANG_EMAIL_EVERY', 26, 26 ),
                      27 => $L10n->getText('LANG_EMAIL_EVERY', 27, 27 ),
                      28 => $L10n->getText('LANG_EMAIL_EVERY', 28, 28 ),
                      29 => $L10n->getText('LANG_EMAIL_EVERY', 29, 29 ),
                      30 => $L10n->getText('LANG_EMAIL_EVERY', 30, 30 ) );
	}
}
?>