<?php
namespace Library\Helper\Markaxis;
use \Library\Runtime\Registry, \Library\Interfaces\IListHelper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: ItemCategoryHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ItemCategoryHelper implements IListHelper {


    // Properties


    /**
     * ItemCategoryHelper Constructor
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
        return array( 'n', 'a', 'd', 'c', 'p', 'l', 'b', 's' );
    }


    /**
     * Return List with Translation
     * @static
     * @return mixed
     */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        return array( 'n' => $L10n->getContents('LANG_NONE'),
                      'a' => $L10n->getContents('LANG_ALLOWANCE'),
                      'd' => $L10n->getContents('LANG_DIRECTORS_FEE'),
                      'c' => $L10n->getContents('LANG_COMMISSION'),
                      'p' => $L10n->getContents('LANG_PENSION'),
                      'l' => $L10n->getContents('LANG_LUMP_SUM'),
                      'b' => $L10n->getContents('LANG_BENEFITS_IN_KIND'),
                      's' => $L10n->getContents('LANG_STOCK_OPTIONS') );
    }
}
?>