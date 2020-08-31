<?php
namespace Markaxis\Cron;
use \Markaxis\Leave\Holiday;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: HolidayModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class HolidayModel extends \Model {


    // Properties
    protected $Holiday;

    private $apiKey = 'AIzaSyADzn12OSGApKSZe0c_GNm58bD2x09imzU';

    protected $countryCal = array( 'AR' => 'en-gb.ar#holiday@group.v.calendar.google.com',
                                    'AU' => 'en-gb.australian#holiday@group.v.calendar.google.com',
                                    'BE' => 'en-gb.be#holiday@group.v.calendar.google.com',
                                    'CA' => 'en-gb.canadian#holiday@group.v.calendar.google.com',
                                    'CN' => 'en-gb.china#holiday@group.v.calendar.google.com',
                                    'DE' => 'en-gb.german#holiday@group.v.calendar.google.com',
                                    'HK' => 'en-gb.hong_kong#holiday@group.v.calendar.google.com',
                                    'ID' => 'en-gb.indonesian#holiday@group.v.calendar.google.com',
                                    'IE' => 'en-gb.irish#holiday@group.v.calendar.google.com',
                                    'IT' => 'en-gb.italian#holiday@group.v.calendar.google.com',
                                    'JP' => 'en-gb.japanese#holiday@group.v.calendar.google.com',
                                    'MY' => 'en-gb.malaysia#holiday@group.v.calendar.google.com',
                                    'NZ' => 'en-gb.new_zealand#holiday@group.v.calendar.google.com',
                                    'SG' => 'en.singapore#holiday@group.v.calendar.google.com',
                                    'SE' => 'en-gb.swedish#holiday@group.v.calendar.google.com',
                                    'CH' => 'en-gb.ch#holiday@group.v.calendar.google.com',
                                    'TH' => 'en-gb.th#holiday@group.v.calendar.google.com',
                                    'GB' => 'en-gb.uk#holiday@group.v.calendar.google.com',
                                    'US' => 'en-gb.usa#holiday@group.v.calendar.google.com',
                                    'VN' => 'en-gb.vietnamese#holiday@group.v.calendar.google.com' );


    /**
     * HolidayModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->Holiday = new Holiday( );
        $this->syncHoliday( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function syncHoliday( ) {
        echo "Sync Holiday Initialized...\n";

        foreach( $this->countryCal as $key => $value ) {
            echo "Syncing $value\n";

            $apiURL = 'https://content.googleapis.com/calendar/v3/calendars/' . urlencode( $value ) . '/events'.
                      '?singleEvents=false'.
                      '&timeMax=' . date('Y-m-d', mktime(0, 0, 0,
                                                                12, 31, date('Y')  ) ) . 'T00:00:00-00:00' .
                      '&timeMin=' . date('Y-m-d', mktime(0, 0, 0,
                                                                1, 1, date('Y')  ) ) . 'T00:00:00-00:00' .
                      '&key=' . $this->apiKey;

            $response = json_decode( file_get_contents( $apiURL ),true );

            if( isset( $response['items'] ) ) {
                foreach( $response['items'] as $holiday ) {
                    $info = array( );
                    $info['countryCode'] = $key;
                    $info['title'] = $holiday['summary'];
                    $info['date'] = $holiday['start']['date'];
                    $info['workDay'] = 0;
                    $this->Holiday->insert('holiday', $info );
                }

                /* Not sorting cos just insert to DB. SQL can sort themselves.
                 * usort($result, function ($a, $b) {
                    if ($a['date'] == $b['date']) {
                        return 0;
                    }

                    return ($a['date'] < $b['date']) ? -1 : 1;
                });*/
            }
        }
        echo "End Sync Holiday\n";
    }
}
?>