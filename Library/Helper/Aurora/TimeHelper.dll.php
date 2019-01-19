<?php
namespace Library\Helper\Aurora;
use \Library\Runtime\Registry, \Library\Interfaces\IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: TimeHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TimeHelper implements IListHelper {


    // Properties


    /**
    * TimeHelper Constructor
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
        return array( '0000', '0030', '0100', '0130', '0200', '0230', '0300',
                      '0330', '0400', '0430', '0500', '0530', '0600', '0630',
                      '0700', '0730', '0800', '0830', '0900', '0930', '1000',
                      '1030', '1100', '1130', '1200', '1230', '1300', '1330',
                      '1400', '1430', '1500', '1530', '1600', '1630', '1700',
                      '1730', '1800', '1830', '1900', '1930', '2000', '2030',
                      '2100', '2130', '2200', '2230', '2300', '2330' );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Aurora/Helper/TimeRes');

        return array( '0000' => '12:00 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '0030' => '12:30 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '0100' => '01:00 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '0130' => '01:30 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '0200' => '02:00 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '0230' => '02:30 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '0300' => '03:00 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '0330' => '03:30 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '0400' => '04:00 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '0430' => '04:30 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '0500' => '05:00 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '0530' => '05:30 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '0600' => '06:00 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '0630' => '06:30 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '0700' => '07:00 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '0730' => '07:30 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '0800' => '08:00 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '0830' => '08:30 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '0900' => '09:00 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '0930' => '09:30 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '1000' => '10:00 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '1030' => '10:30 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '1100' => '11:00 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '1130' => '11:30 ' . $L10n->getContents('LANG_ANTE_MERIDIEM'),
                      '1200' => '12:00 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '1230' => '12:30 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '1300' => '01:00 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '1330' => '01:30 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '1400' => '02:00 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '1430' => '02:30 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '1500' => '03:00 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '1530' => '03:30 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '1600' => '04:00 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '1630' => '04:30 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '1700' => '05:00 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '1730' => '05:30 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '1800' => '06:00 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '1830' => '06:30 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '1900' => '07:00 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '1930' => '07:30 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '2000' => '08:00 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '2030' => '08:30 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '2100' => '09:00 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '2130' => '09:30 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '2200' => '10:00 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '2230' => '10:30 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '2300' => '11:00 ' . $L10n->getContents('LANG_POST_MERIDIEM'),
                      '2330' => '11:30 ' . $L10n->getContents('LANG_POST_MERIDIEM') );
	}
}
?>