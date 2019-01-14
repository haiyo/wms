<?php
namespace Library\Helper\Markaxis;
use \Library\Runtime\Registry, \IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ReportTypeHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ReportTypeHelper implements IListHelper {


    // Properties


    /**
    * ReportTypeHelper Constructor
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
        return array( 'pdf', 'excel', 'both' );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Markaxis/SEO/ClientList/Helper/ReportTypeRes');

        return array( 'pdf'   => $L10n->getContents('LANG_PDF'),
                      'excel' => $L10n->getContents('LANG_EXCEL'),
                      'both'  => $L10n->getContents('LANG_BOTH') );
	}
}
?>