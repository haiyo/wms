<?php
namespace Library\Helper\Markaxis;
use \Library\Runtime\Registry, \Library\Interfaces\IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: ManagePermHelper.dll.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ManagePermHelper implements IListHelper {


    // Properties


    /**
    * ManagePermHelper Constructor
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
        return array( 'viewAll', 'changes', 'changeShare' );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Markaxis/CalendarToolbar/Helper/ManagePermRes');

        return array( 'viewAll'  => $L10n->getContents('LANG_VIEW_ALL'),
                      'changes' => $L10n->getContents('LANG_MAKE_CHANGES'),
                      'changeShare' => $L10n->getContents('LANG_MAKE_CHANGES_SHARING') );
	}
}
?>