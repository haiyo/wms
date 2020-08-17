<?php
namespace Markaxis\Calendar;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CalendarControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarControl {


    // Properties
    protected $CalendarModel;
    protected $CalendarView;


    /**
    * CalendarControl Constructor
    * @return void
    */
    function __construct( ) {
        $this->CalendarModel = CalendarModel::getInstance( );
        $this->CalendarView = new CalendarView( );
	}


    /**
     * Render main navigation
     * @return string
     */
    public function dashboard( ) {
        Control::setOutputArrayAppend( array( 'sidebarCards' => $this->CalendarView->renderUpcomingEvents( ) ) );
    }


    /**
    * Show Calendar
    * @return void
    */
    public function view( ) {
        $date = getdate( time( ) );
        $this->CalendarView->printAll( $this->CalendarView->renderCalendar( $date ) );
	}
}
?>