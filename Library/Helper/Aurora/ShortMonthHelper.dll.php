<?php
namespace Library\Helper\Aurora;
use \Library\Runtime\Registry, \Library\Interfaces\IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: ShortMonthHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ShortMonthHelper implements IListHelper {


    // Properties


    /**
    * ShortMonthHelper Constructor
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
        return array( '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12' );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Aurora/Helper/CalendarRes');

        return array( '01' => $L10n->getContents('LANG_JAN'),
                      '02' => $L10n->getContents('LANG_FEB'),
                      '03' => $L10n->getContents('LANG_MAR'),
                      '04' => $L10n->getContents('LANG_APR'),
                      '05' => $L10n->getContents('LANG_MAY'),
                      '06' => $L10n->getContents('LANG_JUN'),
                      '07' => $L10n->getContents('LANG_JUL'),
                      '08' => $L10n->getContents('LANG_AUG'),
                      '09' => $L10n->getContents('LANG_SEP'),
                      '10' => $L10n->getContents('LANG_OCT'),
                      '11' => $L10n->getContents('LANG_NOV'),
                      '12' => $L10n->getContents('LANG_DEC') );
	}
}
?>