<?php
namespace Library\Helper\Aurora;
use \Library\Runtime\Registry, \Library\Interfaces\IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: StrongNameHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class StrongNameHelper implements IListHelper {


    // Properties


    /**
    * StrongNameHelper Constructor
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
        return array( 'none', 'min', 'alpha', 'all' );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Aurora/Helper/StrongNameRes');

        return array( 'none'  => $L10n->getContents('LANG_NONE'),
                      'min'   => $L10n->getContents('LANG_MIN_MAX'),
                      'alpha' => $L10n->getContents('LANG_ALPHANUM'),
                      'all'   => $L10n->getContents('LANG_ALL_RULES') );
	}
}
?>