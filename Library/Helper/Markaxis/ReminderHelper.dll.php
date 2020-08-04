<?php
namespace Library\Helper\Markaxis;
use \Library\Runtime\Registry, \Library\Interfaces\IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ReminderHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ReminderHelper implements IListHelper {


    // Properties


    /**
    * ReminderHelper Constructor
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
        return array( '1', '2', '3', '4', '5', '24', '48' );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Markaxis/Helper/ReminderRes');

        return array( '1'  => $L10n->getText('LANG_ONE_HOUR_BEFORE', 1, 1 ),
                      '2'  => $L10n->getText('LANG_ONE_HOUR_BEFORE', 2, 2 ),
                      '3'  => $L10n->getText('LANG_ONE_HOUR_BEFORE', 3, 3 ),
                      '4'  => $L10n->getText('LANG_ONE_HOUR_BEFORE', 4, 4 ),
                      '5'  => $L10n->getText('LANG_ONE_HOUR_BEFORE', 5, 5 ),
                      '24' => $L10n->getText('LANG_ONE_DAY_BEFORE', 1, 1 ),
                      '48' => $L10n->getText('LANG_ONE_DAY_BEFORE', 2, 2 ) );
	}
}
?>