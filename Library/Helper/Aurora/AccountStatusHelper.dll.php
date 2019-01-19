<?php
namespace Library\Helper\Aurora;
use \Library\Runtime\Registry, \Library\Interfaces\IListHelper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: AccountStatusHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AccountStatusHelper implements IListHelper {


    // Properties


    /**
    * AccountStatusHelper Constructor
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
        return array( 'active', 'pending', 'suspended' );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Aurora/Helper/AccountStatusRes');

        return array( 'active' => $L10n->getContents('LANG_ACTIVE'),
                      'pending' => $L10n->getContents('LANG_PENDING'),
                      'suspended' => $L10n->getContents('LANG_SUSPENDED') );
	}
}
?>