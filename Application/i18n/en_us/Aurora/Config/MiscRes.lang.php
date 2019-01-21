<?php
namespace Aurora;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: MiscRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class MiscRes extends Resource {


    /**
    * MiscRes Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( ); // Call construct to initialize rules for date format!
        
        $this->contents = array( );
        $this->contents['LANG_MENU_LINK_TITLE'] = 'i18n / Miscellaneous Settings';
        $this->contents['LANG_THEME'] = 'Aurora Default Theme';
        $this->contents['LANG_THEME_DESC'] = 'Select a different theme for your Aurora System. Themes may be downloaded from the <a href="http://aurora.markaxis.com" target="_blank">Official Aurora Website</a>.';

        $this->contents['LANG_DISPLAY_LOGO'] = 'Display Company Logo';
        $this->contents['LANG_DISPLAY_LOGO_DESC'] = 'Choose whether to display your company logo.';

        $this->contents['LANG_GRAPHIC'] = 'Graphic Library Extension';
        $this->contents['LANG_GRAPHIC_DESC'] = 'Choose the type of graphic library available in the server. The library
              is use for image manipulation, such as drawing and resizing.';
        $this->contents['LANG_DETECT_IMAGICK'] = '<strong>Note:</strong> Aurora has detected ImageMagick library installed
            in the server<span style="display:{GD_INFO_DISPLAY}"> which is much better than the current GD library</span>,
            but is unable to ultilize it due to a possible
            <strong>open_basedir restriction</strong>. To enable the library, please consult your hosting provider.
            <span style="display:{GD_INFO_DISPLAY}">You may still continue to use the current library but with a lower quiality and require higher server
            resources.</span>';
        $this->contents['LANG_TIME_ZONE'] = 'Time Zone Settings';
        $this->contents['LANG_TIME_ZONE_DESC'] = 'Set the correct time zone based on the server\'s setting. Aurora will observe
              Daylight Saving Time (DST) if available.';
        $this->contents['LANG_DEFAULT_LANGUAGE'] = 'Default Language';
        $this->contents['LANG_DEFAULT_LANGUAGE_DESC'] = 'Select the default language for the Aurora System. New languages
              can be created at System Control / Translation Center.';
        $this->contents['LANG_REGION_DATE'] = 'Regional Date Settings';
        $this->contents['LANG_REGION_DATE_DESC'] = 'Choose the preferred type of date format use throughout the system.';
        $this->contents['LANG_REGION_TIME'] = 'Regional Time Settings';
        $this->contents['LANG_REGION_TIME_DESC'] = 'Choose the preferred type of time format use throughout the system.';
        $this->contents['LANG_CURRENCY'] = 'Currency Symbol';
        $this->contents['LANG_CURRENCY_DESC'] = 'Specify the preferred type of currency symbol and formats used for
              positive or negative amounts. For i.e. USD$';
	}
}
?>