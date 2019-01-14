<?php
namespace Library\Helper\Aurora;
use \Library\Runtime\Registry, \IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: TimeOutHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TimeOutHelper implements IListHelper {


    // Properties


    /**
    * TimeOutHelper Constructor
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
        return array( '0', '60', '180', '300', '600', '900', '1200', '1800', '2400',
                      '3000', '3600', '7200', '10800', '14400', '18000' );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Aurora/Helper/TimeOutRes');

        return array( '0'     => $L10n->getContents('LANG_NEVER'),
                      '60'    => $L10n->getText('LANG_N_MINUTE', 1 ),
                      '180'   => $L10n->getText('LANG_N_MINUTE', 3 ),
                      '300'   => $L10n->getText('LANG_N_MINUTE', 5 ),
                      '600'   => $L10n->getText('LANG_N_MINUTE', 10 ),
                      '900'   => $L10n->getText('LANG_N_MINUTE', 15 ),
                      '1200'  => $L10n->getText('LANG_N_MINUTE', 20 ),
                      '1800'  => $L10n->getText('LANG_N_MINUTE', 30 ),
                      '2400'  => $L10n->getText('LANG_N_MINUTE', 40 ),
                      '3000'  => $L10n->getText('LANG_N_MINUTE', 50 ),
                      '3600'  => $L10n->getText('LANG_N_HOUR', 1 ),
                      '7200'  => $L10n->getText('LANG_N_HOUR', 2 ),
                      '10800' => $L10n->getText('LANG_N_HOUR', 3 ),
                      '14400' => $L10n->getText('LANG_N_HOUR', 4 ),
                      '18000' => $L10n->getText('LANG_N_HOUR', 5 ) );
	}
}
?>