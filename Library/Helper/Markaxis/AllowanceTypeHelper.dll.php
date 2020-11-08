<?php
namespace Library\Helper\Markaxis;
use \Library\Runtime\Registry, \Library\Interfaces\IListHelper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: AllowanceTypeHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AllowanceTypeHelper implements IListHelper {


    // Properties


    /**
     * AllowanceTypeHelper Constructor
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
        return array( 't', 'e', 'o' );
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

        return array( 't' => $L10n->getContents('LANG_TRANSPORT'),
                      'e' => $L10n->getContents('LANG_ENTERTAINMENT'),
                      'o' => $L10n->getContents('LANG_OTHERS') );
    }
}
?>