<?php
namespace Library\Helper\Markaxis;
use \Library\Runtime\Registry, \IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: EndRecurHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EndRecurHelper implements IListHelper {


    // Properties


    /**
    * EndRecurHelper Constructor
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
        return array( 'never', 'untilDate' );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Markaxis/Calendar/Helper/RecurRes');

        return array( 'never' => $L10n->getContents('LANG_NEVER'),
                      'untilDate' => $L10n->getContents('LANG_UNTIL_DATE') );
	}
}
?>