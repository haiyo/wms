<?php
namespace Library\Helper\Markaxis;
use \Library\Runtime\Registry, \IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: CalHeightHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalHeightHelper implements IListHelper {


    // Properties


    /**
    * CalHeightHelper Constructor
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
        return array( 'proportion', 'stretch' );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Markaxis/Calendar/Helper/CalHeightRes');

        return array( 'proportion' => $L10n->getContents('LANG_PROPORTION'),
                      'stretch'    => $L10n->getContents('LANG_STRETCH') );
	}
}
?>