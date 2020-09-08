<?php
namespace Markaxis\Calendar;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: CalendarRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarRes extends Resource {


    // Properties


    /**
     * CalendarRes Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->contents = array( );
        $this->contents['LANG_CALENDAR'] = 'View Calendar';
        $this->contents['LANG_FILTER_EVENT_TYPES'] = 'Filter Event Types';
        $this->contents['LANG_MY_EVENTS'] = 'My Events';
        $this->contents['LANG_COLLEAGUE_EVENTS'] = 'Colleague Events';
        $this->contents['LANG_INCLUDE_BIRTHDAYS'] = 'Include Birthdays';
        $this->contents['LANG_INCLUDE_HOLIDAYS'] = 'Include Holidays';
        $this->contents['LANG_PUBLIC_EVENT'] = 'Public Event (Everyone can see)';
        $this->contents['LANG_EVENT_LABEL'] = 'Event Label';
        $this->contents['LANG_SEND_EMAIL_REMINDER'] = 'Send Email Reminder';
        $this->contents['LANG_RECURRING_EVERY'] = 'Recurring Every';
        $this->contents['LANG_END_TIME'] = 'End Time';
        $this->contents['LANG_START_TIME'] = 'Start Time';
        $this->contents['LANG_WHOLE_DAY_EVENT'] = 'Whole Day Event';
        $this->contents['LANG_END_DATE'] = 'End Date';
        $this->contents['LANG_START_DATE'] = 'Start Date';
        $this->contents['LANG_EVENT_DESCRIPTION'] = 'Event Description';
        $this->contents['LANG_DAILY_MEETING'] = 'For e.g: Daily standup meeting';
        $this->contents['LANG_EVENT_TITLE'] = 'Event Title';
        $this->contents['LANG_MEETING_3PM'] = 'For e.g: Meeting at 3pm';
    }
}
?>