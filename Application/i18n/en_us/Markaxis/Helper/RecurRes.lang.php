<?php
namespace Markaxis\Helper;
use \Resource;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: RecurRes.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RecurRes extends Resource {


    // Properties


    /**
    * RecurRes Constructor
    * @return void
    */
    function __construct( ) {
        $this->contents = array( );
        $this->contents['LANG_HOURLY'] = 'Hourly';
        $this->contents['LANG_DAILY'] = 'Daily';
        $this->contents['LANG_WEEKLY'] = 'Weekly';
        $this->contents['LANG_EVERY_2_WEEKS'] = 'Every 2 Weeks';
        $this->contents['LANG_MONTHLY'] = 'Monthly';
        $this->contents['LANG_YEARLY'] = 'Yearly';
        $this->contents['LANG_MON_FRI'] = 'Every weekday (Mon-Fri)';
        $this->contents['LANG_MON_WED_FRI'] = 'Every Mon, Wed and Fri';
        $this->contents['LANG_TUE_THUR'] = 'Every Tues and Thurs';
        $this->contents['LANG_DAY_OF_MONTH'] = 'Monthly by day';
        $this->contents['LANG_NEVER'] = 'Never';
        $this->contents['LANG_AFTER_OCCUR'] = 'Repeat no. of times';
        $this->contents['LANG_UNTIL_DATE'] = 'Until date';
	}
}
?>