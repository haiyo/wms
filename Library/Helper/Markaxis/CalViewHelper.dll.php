<?php
namespace Library\Helper\Markaxis;
use \Library\Runtime\Registry, \Library\Interfaces\IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: CalViewHelper.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalViewHelper implements IListHelper {


    // Properties


    /**
    * CalViewHelper Constructor
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
        return array( 'agendaDay', 'agendaWeek', 'month', 'last' );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Markaxis/Calendar/Helper/CalViewRes');

        return array( 'agendaDay'  => $L10n->getContents('LANG_DAY'),
                      'agendaWeek' => $L10n->getContents('LANG_WEEK'),
                      'month' => $L10n->getContents('LANG_MONTH'),
                      'last'  => $L10n->getContents('LANG_LAST_VIEW') );
	}
}
?>