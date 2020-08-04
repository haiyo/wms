<?php
namespace Library\Helper\Markaxis;
use \Library\Runtime\Registry, \Library\Interfaces\IListHelper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: RecurHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RecurHelper implements IListHelper {


    // Properties


    /**
    * RecurHelper Constructor
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
        return array( 'day', 'week', 'biweekly', 'month', 'year', 'weekday', 'monWedFri', 'tueThur', /*'dayOfMonth'*/ );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Markaxis/Helper/RecurRes');

        return array( 'day' => $L10n->getContents('LANG_DAILY'),
                      'week' => $L10n->getContents('LANG_WEEKLY'),
                      'biweekly' => $L10n->getContents('LANG_EVERY_2_WEEKS'),
                      'month' => $L10n->getContents('LANG_MONTHLY'),
                      'year' => $L10n->getContents('LANG_YEARLY'),
                      'weekday' => $L10n->getContents('LANG_MON_FRI'),
                      'monWedFri' => $L10n->getContents('LANG_MON_WED_FRI'),
                      'tueThur' => $L10n->getContents('LANG_TUE_THUR') );
	}
}
?>