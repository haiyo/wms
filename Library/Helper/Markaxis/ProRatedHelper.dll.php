<?php
namespace Library\Helper\Markaxis;
use \Library\Runtime\Registry, \IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ProRatedHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ProRatedHelper implements IListHelper {


    // Properties


    /**
    * ProRatedHelper Constructor
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
        return array( '0', '1' );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Markaxis/Leave/LeaveRes');

        return array( '0'  => $L10n->getContents('LANG_NOT_PRO_RATED'),
                      '1'  => $L10n->getContents('LANG_PRO_RATED') );
	}
}
?>