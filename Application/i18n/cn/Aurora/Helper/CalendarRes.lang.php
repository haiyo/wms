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
        $this->contents['LANG_SUNDAY']    = '星期日';
        $this->contents['LANG_MONDAY']    = '星期一';
        $this->contents['LANG_TUESDAY']   = '星期二';
        $this->contents['LANG_WEDNESDAY'] = '星期三';
        $this->contents['LANG_THURSDAY']  = '星期四';
        $this->contents['LANG_FRIDAY']    = '星期五';
        $this->contents['LANG_SATURDAY']  = '星期六';
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
        $this->contents['LANG_JANUARY']   = '一月';
        $this->contents['LANG_FEBRUARY']  = '二月';
        $this->contents['LANG_MARCH']     = '三月';
        $this->contents['LANG_APRIL']     = '四月';
        $this->contents['LANG_MAY']       = '五月';
        $this->contents['LANG_JUNE']      = '六月';
        $this->contents['LANG_JULY']      = '七月';
        $this->contents['LANG_AUGUST']    = '八月';
        $this->contents['LANG_SEPTEMBER'] = '九月';
        $this->contents['LANG_OCTOBER']   = '十月';
        $this->contents['LANG_NOVEMBER']  = '十一月';
        $this->contents['LANG_DECEMBER']  = '十二月';
        $this->contents['LANG_WK'] = 'Wk';
        $this->contents['LANG_YEAR'] = '年';
        $this->contents['LANG_MONTH'] = '月';
        $this->contents['LANG_WEEK'] = '周';
        $this->contents['LANG_DAY'] = '日';
        $this->contents['LANG_YEARS'] = '年';
        $this->contents['LANG_MONTHS'] = '月';
        $this->contents['LANG_WEEKS'] = '周';
        $this->contents['LANG_DAYS'] = '日';
        $this->contents['LANG_N_DAY'] = '{n} 日';
        $this->contents['LANG_N_DAY'] = '{n} 周';
        $this->contents['LANG_N_DAY'] = '{n} 月';
        $this->contents['ALL_DAY'] = '一整天';
        $this->contents['LANG_TODAY'] = '今天';
        $this->contents['LANG_REMINDER_SET'] = '提醒集';
        $this->contents['LANG_REPEAT'] = '重复';
	}
}
?>