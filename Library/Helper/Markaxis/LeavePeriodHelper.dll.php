<?php
namespace Library\Helper\Markaxis;
use \Library\Runtime\Registry, \Library\Interfaces\IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LeavePeriodHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeavePeriodHelper implements IListHelper {


    // Properties


    /**
    * LeavePeriodHelper Constructor
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

        return array( 'months'  => $L10n->getContents('LANG_MONTHS'),
                      'weeks'  => $L10n->getContents('LANG_WEEKS'),
                      'days'  => $L10n->getContents('LANG_DAYS') );
	}
}
?>