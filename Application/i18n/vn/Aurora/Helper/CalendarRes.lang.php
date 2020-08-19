<?php
namespace Aurora\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, July  30, 2012
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
        $this->contents = array( );
        $this->contents['LANG_SU'] = 'Su';
        $this->contents['LANG_MO'] = 'Mo';
        $this->contents['LANG_TU'] = 'Tu';
        $this->contents['LANG_WE'] = 'We';
        $this->contents['LANG_TH'] = 'Th';
        $this->contents['LANG_FR'] = 'Fr';
        $this->contents['LANG_SA'] = 'Sa';
        $this->contents['LANG_SUN'] = 'Sun';
        $this->contents['LANG_MON'] = 'Mon';
        $this->contents['LANG_TUE'] = 'Tue';
        $this->contents['LANG_WED'] = 'Wed';
        $this->contents['LANG_THU'] = 'Thu';
        $this->contents['LANG_FRI'] = 'Fri';
        $this->contents['LANG_SAT'] = 'Sat';
        $this->contents['LANG_SUNDAY']    = 'Chủ nhật';
        $this->contents['LANG_MONDAY']    = 'Thứ hai';
        $this->contents['LANG_TUESDAY']   = 'Thứ ba';
        $this->contents['LANG_WEDNESDAY'] = 'Thứ tư';
        $this->contents['LANG_THURSDAY']  = 'Thứ năm';
        $this->contents['LANG_FRIDAY']    = 'Thứ sáu';
        $this->contents['LANG_SATURDAY']  = 'Thứ bảy';
        $this->contents['LANG_JAN'] = 'Jan';
        $this->contents['LANG_FEB'] = 'Feb';
        $this->contents['LANG_MAR'] = 'Mar';
        $this->contents['LANG_APR'] = 'Apr';
        $this->contents['LANG_MAY'] = 'May';
        $this->contents['LANG_JUN'] = 'Jun';
        $this->contents['LANG_JUL'] = 'Jul';
        $this->contents['LANG_AUG'] = 'Aug';
        $this->contents['LANG_SEP'] = 'Sep';
        $this->contents['LANG_OCT'] = 'Oct';
        $this->contents['LANG_NOV'] = 'Nov';
        $this->contents['LANG_DEC'] = 'Dec';
        $this->contents['LANG_JANUARY']   = 'Tháng 1';
        $this->contents['LANG_FEBRUARY']  = 'Tháng 2';
        $this->contents['LANG_MARCH']     = 'Tháng 3';
        $this->contents['LANG_APRIL']     = 'Tháng 4';
        $this->contents['LANG_MAY']       = 'Tháng 5';
        $this->contents['LANG_JUNE']      = 'Tháng 6';
        $this->contents['LANG_JULY']      = 'Tháng 7';
        $this->contents['LANG_AUGUST']    = 'tháng 8';
        $this->contents['LANG_SEPTEMBER'] = 'Tháng 9';
        $this->contents['LANG_OCTOBER']   = 'Tháng 10';
        $this->contents['LANG_NOVEMBER']  = 'Tháng 11';
        $this->contents['LANG_DECEMBER']  = 'Tháng 12';
        $this->contents['LANG_WK'] = 'Wk';
        $this->contents['LANG_YEAR'] = 'Year';
        $this->contents['LANG_MONTH'] = 'Month';
        $this->contents['LANG_WEEK'] = 'Week';
        $this->contents['LANG_DAY'] = 'Day';
        $this->contents['LANG_YEARS'] = 'Years';
        $this->contents['LANG_MONTHS'] = 'months';
        $this->contents['LANG_WEEKS'] = 'weeks';
        $this->contents['LANG_DAYS'] = 'days';
        $this->contents['LANG_N_DAY'] = '{n} day|days';
        $this->contents['LANG_N_DAY'] = '{n} week|weeks';
        $this->contents['LANG_N_DAY'] = '{n} month|months';
        $this->contents['ALL_DAY'] = 'All Day';
        $this->contents['LANG_TODAY'] = 'Today';
        $this->contents['LANG_REMINDER_SET'] = 'Reminder Set';
        $this->contents['LANG_REPEAT'] = 'Repeat';
	}
}
?>