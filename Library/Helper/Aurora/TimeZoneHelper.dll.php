<?php
namespace Library\Helper\Aurora;
use \IListHelper;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
 * @version $Id: TimeZoneHelper.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TimeZoneHelper implements IListHelper {


    // Properties


    /**
    * TimeZoneHelper Constructor
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
        $zones = timezone_identifiers_list( );
        $locations = array( );

        foreach( $zones as $zone ) {
            $zoneExploded = explode( '/', $zone ); // 0 => Continent, 1 => City

            // Only use "friendly" continent names
            if( $zoneExploded[0] == 'Africa' || $zoneExploded[0] == 'America' ||
                $zoneExploded[0] == 'Antarctica' || $zoneExploded[0] == 'Arctic' || 
                $zoneExploded[0] == 'Asia' || $zoneExploded[0] == 'Atlantic' || 
                $zoneExploded[0] == 'Australia' || $zoneExploded[0] == 'Europe' || 
                $zoneExploded[0] == 'Indian' || $zoneExploded[0] == 'Pacific' ) {
                
                if( isset( $zoneExploded[1] ) != '' ) {
                    $area = str_replace( '_', ' ', $zoneExploded[1] );

                    if( !empty( $zoneExploded[2] ) ) {
                        $area = $area . ' (' . str_replace('_', ' ', $zoneExploded[2]) . ')';
                    }
                    $locations[$zone] = $area; // Creates array(DateTimeZone => 'Friendly name')
                } 
            }
        }
        asort( $locations );
        return $locations;
/*
        return array( 'US/Pacific' => '(UTC-8) Pacific Time (US &amp; Canada)',
                      'US/Mountain' => '(UTC-7) Mountain Time (US &amp; Canada)',
                      'US/Central' => '(UTC-6) Central Time (US &amp; Canada)',
                      'US/Eastern' => '(UTC-5) Eastern Time (US &amp; Canada)',
                      'America/Halifax' => '(UTC-4)  Atlantic Time (Canada)',
                      'America/Anchorage' => '(UTC-9)  Alaska (US &amp; Canada)',
                      'Pacific/Honolulu' => '(UTC-10) Hawaii (US)',
                      'Pacific/Samoa' => '(UTC-11) Midway Island, Samoa',
                      'Etc/GMT-12' => '(UTC-12) Eniwetok, Kwajalein',
                      'Canada/Newfoundland' => '(UTC-3:30) Canada/Newfoundland',
                      'America/Buenos_Aires' => '(UTC-3) Brasilia, Buenos Aires, Georgetown',
                      'Atlantic/South_Georgia' => '(UTC-2) Mid-Atlantic',
                      'Atlantic/Azores' => '(UTC-1) Azores, Cape Verde Is.',
                      'Europe/London' => 'Greenwich Mean Time (Lisbon, London)',
                      'Europe/Berlin' => '(UTC+1) Amsterdam, Berlin, Paris, Rome, Madrid',
                      'Europe/Athens' => '(UTC+2) Athens, Helsinki, Istanbul, Cairo, E. Europe',
                      'Europe/Moscow' => '(UTC+3) Baghdad, Kuwait, Nairobi, Moscow',
                      'Iran'  => '(UTC+3:30) Tehran',
                      'Asia/Dubai' => '(UTC+4) Abu Dhabi, Kazan, Muscat',
                      'Asia/Kabul' => '(UTC+4:30) Kabul',
                      'Asia/Katmandu' => '(UTC+5) Islamabad, Karachi, Tashkent',
                      'Asia/Yekaterinburg' => '(UTC+5:30) Bombay, Calcutta, New Delhi',
                      'Asia/Dili'  => '(UTC+5:45) Nepal',
                      'Asia/Omsk'  => '(UTC+6) Almaty, Dhaka',
                      'India/Cocos'  => '(UTC+6:30) Cocos Islands, Yangon',
                      'Asia/Krasnoyarsk'  => '(UTC+7) Bangkok, Jakarta, Hanoi',
                      'Asia/Singapore'  => '(UTC+8) Beijing, Hong Kong, Singapore, Taipei',
                      'Asia/Tokyo'  => '(UTC+9) Tokyo, Osaka, Sapporto, Seoul, Yakutsk',
                      'Australia/Adelaide'  => '(UTC+9:30) Adelaide, Darwin',
                      'Australia/Sydney'  => '(UTC+10) Brisbane, Melbourne, Sydney, Guam',
                      'Asia/Magadan'  => '(UTC+11) Magadan, Soloman Is., New Caledonia',
                      'Pacific/Auckland'  => '(UTC+12) Fiji, Kamchatka, Marshall Is., Wellington' );*/
	}


    /**
    * Return List with Translation
    * @static
    * @return mixed
    */
    public static function getL10nList( ) {
        //
	}
}
?>