<?php
namespace Library\Helper\Markaxis;
use \Library\Interfaces\IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: GoogleLanguageHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class GoogleLanguageHelper implements IListHelper {


    // Properties


    /**
    * GoogleLanguageHelper Constructor
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
        return array( 'af', 'ar', 'hy', 'be', 'bg', 'ca', 'zh-CN', 'zh-TW',
                      'hr', 'cs', 'da', 'nl', 'en', 'eo', 'et', 'tl', 'fi',
                      'fr', 'de', 'el', 'iw', 'hi', 'hu', 'is', 'id', 'it',
                      'ja', 'ko', 'lv', 'lt', 'no', 'fa', 'pl', 'pt', 'ro',
                      'ru', 'sr', 'sk', 'sl', 'es', 'sw', 'sv', 'th', 'tr',
                      'uk', 'vi' );
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        return array( 'af' => 'Afrikaans',
                      'ar' => 'Arabic',
                      'hy' => 'Armenian',
                      'be' => 'Belarusian',
                      'bg' => 'Bulgarian',
                      'ca' => 'Catalan',
                      'zh-CN' => 'Chinese (Simplified)',
                      'zh-TW' => 'Chinese (Traditional)',
                      'hr' => 'Croatian',
                      'cs' => 'Czech',
                      'da' => 'Danish',
                      'nl' => 'Dutch',
                      'en' => 'English',
                      'eo' => 'Esperanto',
                      'et' => 'Estonian',
                      'tl' => 'Filipino',
                      'fi' => 'Finnish',
                      'fr' => 'French',
                      'de' => 'German',
                      'el' => 'Greek',
                      'iw' => 'Hebrew',
                      'hi' => 'Hindi',
                      'hu' => 'Hungarian',
                      'is' => 'Icelandic',
                      'id' => 'Indonesian',
                      'it' => 'Italian',
                      'ja' => 'Japanese',
                      'ko' => 'Korean',
                      'lv' => 'Latvian',
                      'lt' => 'Lithuanian',
                      'no' => 'Norwegian',
                      'fa' => 'Persian',
                      'pl' => 'Polish',
                      'pt' => 'Portuguese',
                      'ro' => 'Romanian',
                      'ru' => 'Russian',
                      'sr' => 'Serbian',
                      'sk' => 'Slovak',
                      'sl' => 'Slovenian',
                      'es' => 'Spanish',
                      'sw' => 'Swahili',
                      'sv' => 'Swedish',
                      'th' => 'Thai',
                      'tr' => 'Turkish',
                      'uk' => 'Ukrainian',
                      'vi' => 'Vietnamese' );
	}
}
?>