<?php
namespace Library\Helper\Markaxis;
use \Library\Runtime\Registry, \Library\Interfaces\IListHelper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: LumpSumTypeHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LumpSumTypeHelper implements IListHelper {


    // Properties


    /**
     * LumpSumTypeHelper Constructor
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
        return array( 'g', 'n', 'e', 'o' );
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

        return array( 'g' => $L10n->getContents('LANG_GRATUITY'),
                      'n' => $L10n->getContents('LANG_NOTICE_PAY'),
                      'e' => $L10n->getContents('LANG_EX_GRATIA_PAYMENT'),
                      'o' => $L10n->getContents('LANG_OTHERS') );
    }
}
?>