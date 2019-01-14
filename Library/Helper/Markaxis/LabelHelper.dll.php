<?php
namespace Library\Helper\Markaxis;
use \Library\Runtime\Registry, \IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LabelHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LabelHelper implements IListHelper {


    // Properties


    /**
    * LabelHelper Constructor
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
        return array( 'blue', 'red', 'gold', 'green', 'purple', 'peach', 'yellow', 'grey', 'turquoise', 'cyan' );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        $Registry = Registry::getInstance( );
        $i18n = $Registry->get( HKEY_CLASS, 'i18n' );
        $L10n = $i18n->loadLanguage('Markaxis/Calendar/Helper/LabelRes');

        return array( 'blue' => $L10n->getContents('LANG_BUSINESS'),
                      'red' => $L10n->getContents('LANG_IMPORTANT'),
                      'gold' => $L10n->getContents('LANG_PREPARATION'),
                      'green' => $L10n->getContents('LANG_PERSONAL'),
                      'purple' => $L10n->getContents('LANG_BIRTHDAY'),
                      'peach' => $L10n->getContents('LANG_MUST_ATTEND'),
                      'yellow' => $L10n->getContents('LANG_PHONE_CALL'),
                      'grey' => $L10n->getContents('LANG_VACATION'),
                      'turquoise' => $L10n->getContents('LANG_ANNIVERSARY'),
                      'cyan' => $L10n->getContents('LANG_TRAVEL') );
	}
}
?>