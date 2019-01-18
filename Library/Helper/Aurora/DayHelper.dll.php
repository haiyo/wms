<?php
namespace Library\Helper\Aurora;
use \Library\Runtime\Registry, \Library\Interfaces\IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: DayHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DayHelper implements IListHelper {


    // Properties


    /**
    * DayHelper Constructor
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
        return array( '', 'sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat' );
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

        return array( 'sun' => $L10n->getContents('LANG_SUNDAY'),
                      'mon' => $L10n->getContents('LANG_MONDAY'),
                      'tue' => $L10n->getContents('LANG_TUESDAY'),
                      'wed' => $L10n->getContents('LANG_WEDNESDAY'),
                      'thu' => $L10n->getContents('LANG_THURSDAY'),
                      'fri' => $L10n->getContents('LANG_FRIDAY'),
                      'sat' => $L10n->getContents('LANG_SATURDAY') );
	}
}
?>