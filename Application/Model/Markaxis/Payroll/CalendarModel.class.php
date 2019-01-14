<?php
namespace Markaxis\Payroll;
use \Library\IO\File;
use \Validator;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: CalendarModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarModel extends \Model {


    // Properties



    /**
     * CalendarModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/PayrollRes');
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getList( ) {
        File::import(DAO . 'Markaxis/Payroll/Calendar.class.php');
        $Calendar = new Calendar( );
        return $Calendar->getList( );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getCalResults( $data ) {
        File::import( DAO . 'Markaxis/Payroll/Calendar.class.php' );
        $Calendar = new Calendar( );
        $Calendar->setLimit( $data['start'], $data['length'] );

        $order = 'pc.calName';
        $dir   = isset( $data['order'][0]['dir'] ) && $data['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $data['order'][0]['column'] ) ) {
            switch( $data['order'][0]['column'] ) {
                case 1:
                    $order = 'pc.calName';
                    break;
                case 2:
                    $order = 'pc.payPeriod';
                    break;
                case 3:
                    $order = 'pc.startDate';
                    break;
                case 4:
                    $order = 'pc.paymentDate';
                    break;
            }
        }

        $results = $Calendar->getCalResults( $data['search']['value'], $order . $dir );
        $sizeof  = sizeof( $results );

        File::import( LIB . 'Util/Markaxis/Calendar/Recur.dll.php' );
        File::import( LIB . 'Util/Markaxis/Calendar/Event.dll.php' );
        $currDate = new \DateTime( );

        for( $i=0; $i<$sizeof; $i++ ) {
            if( isset( $results[$i] ) ) {
                switch( $results[$i]['payPeriod'] ) {
                    case 'weekly' :
                        File::import( LIB . 'Util/Markaxis/Calendar/DayRecur.dll.php' );
                        File::import( LIB . 'Util/Markaxis/Calendar/WeekRecur.dll.php' );
                        // Setup canvas for NOW to next week
                        $nextWeek = new \DateTime( );
                        $nextWeek = $nextWeek->modify('+1 week');

                        $WeekRecur = new WeekRecur( $currDate->format( 'Y-m-d' ), $nextWeek->format( 'Y-m-d' ) );

                        $startEvent = new \DateTime( $results[$i]['startDate'] );
                        $endEvent = new \DateTime( $results[$i]['startDate'] );
                       // $endEvent->modify( '+1 week' );

                        //$diff = $currDate->diff( $eventDate );

                        $paymentDate = new \DateTime( $results[$i]['paymentDate'] );

                        $WeekRecur->setEvent( new Event( array( 'start' => $startEvent->format( 'Y-m-d' ), 'end' => $endEvent->format( 'Y-m-d' ),
                                                                'recurType' => 'week', 'endRecur' => 'never' ) ) );
                        $collections = $WeekRecur->getEvents( );
                        $collections = array_slice( $collections, -2, 2, true );
                        $collections = array_values( $collections );

                        if( isset( $collections[0] ) && isset( $collections[1] ) ) {
                            $nextStart = new \DateTime( $collections[0]['start'] );
                            $nextEnd = new \DateTime( $collections[1]['end'] );

                            $results[$i]['nextPayPeriod'] = $nextStart->format( 'jS F Y' ) . ' &mdash; ' . $nextEnd->format( 'jS F Y' );
                            $results[$i]['nextPayment'] = $nextEnd->format('jS F Y');
                        }
                        break;
                    case 'monthly' :
                        File::import( LIB . 'Util/Markaxis/Calendar/MonthRecur.dll.php' );

                        // Setup canvas for NOW to next month
                        //$nextMonth = MonthRecur::addMonth( $currDate, $currDate );
                        $MonthRecur = new MonthRecur( $currDate->format( 'Y-m-01' ), $currDate->format( 'Y-m-t' ) ); //2018-08-01 == 2018-09-01

                        $startEvent = new \DateTime( $results[$i]['startDate'] ); // 2018-08-01
                        //$endEvent = new \DateTime( $results[$i]['startDate'] );
                        $endEvent = MonthRecur::addMonth( $startEvent, $startEvent );
                        $endEvent->modify( '-1 day' );

                        //echo 'Canvas: ' . $currDate->format( 'Y-m-01' ) . ' ==  ' . $currDate->format( 'Y-m-t' ) . ' || ';
                        //echo 'Event: ' . $startEvent->format( 'Y-m-d' ) . ' ==  ' . $endEvent->format( 'Y-m-d' );

                        /*$diff = $currDate->diff( $eventDate );

                        if( isset( $diff->m ) ) {
                            for( $j=0; $j<$diff->m; $j++ ) {
                                $eventDate = $MonthRecur::addMonth( $eventDate, $eventDate );
                                $paymentDate = $MonthRecur::addMonth( $paymentDate, $paymentDate );
                            }
                        }*/

                        $event = new Event( array( 'start' => $startEvent->format( 'Y-m-d' ), 'end' => $endEvent->format( 'Y-m-d' ),
                                                   'recurType' => 'month', 'endRecur' => 'never', 'repeatTimes' => 1 ) );

                        $MonthRecur->setEvent( $event );
                        $collections = $MonthRecur->getEvents( );

                        if( isset( $collections[1] ) ) {
                            $nextStart = new \DateTime( $collections[1]['start'] );
                            $nextEnd = new \DateTime( $collections[1]['end'] );

                            $results[$i]['nextPayPeriod'] = $nextStart->format( 'jS F Y' ) . ' &mdash; ' . $nextEnd->format( 'jS F Y' );

                            $paymentDate = new \DateTime( $results[$i]['paymentDate'] );
                            $nextStart = MonthRecur::addMonth( $nextStart, $nextStart );
                            $results[$i]['nextPayment']  = $paymentDate->format('jS ');
                            $results[$i]['nextPayment'] .= $nextStart->format('F Y ');
                        }
                        break;
                }
                $results[$i]['payPeriod'] = ucwords( $results[$i]['payPeriod'] );
            }
        }
        //nextPayPeriod
        //nextPayment
        /*
         payPeriod' => string 'month'
      'startDate' => string '2018-08-01'
          'paymentDate' => string '2018-09-01'
         * */

        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$data['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getEndDate( $data ) {
        if( isset( $data['startDate'] ) && isset( $data['payPeriod'] ) ) {
            $startDate = new \DateTime( $data['startDate'] );

            switch( $data['payPeriod'] ) {
                case 'weekly' :
                    $startDate->modify('+1 week' );
                    break;
                case 'biweekly' :
                    $startDate->modify('+2 week' );
                    break;
                case 'monthly' :
                    File::import( LIB . 'Util/Markaxis/Calendar/Recur.dll.php' );
                    File::import( LIB . 'Util/Markaxis/Calendar/MonthRecur.dll.php' );
                    $startDate = MonthRecur::addMonth( $startDate, $startDate );
                    $startDate->modify( '-1 day' );
                    break;
            }
            return $startDate;
        }
        return false;
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getPaymentRecur( $data ) {
        if( isset( $data['startDate'] ) && isset( $data['payPeriod'] ) ) {
            File::import( LIB . 'Util/Markaxis/Calendar/Recur.dll.php' );
            File::import( LIB . 'Util/Markaxis/Calendar/Event.dll.php' );

            // A bug related to @https://stackoverflow.com/questions/17785443/strtotime-and-datetime-giving-wrong-year-when-parsing-a-year
            // Datetime and strtotime is producing WRONG YEAR! We now use createFromFormat() to more accurately match the format we received
            // from the UI calendar.
            $formatBug = \DateTime::createFromFormat( 'j F, Y', $data['startDate'] );
            if( !$formatBug ) return false;

            // Don't use shorthand assign here as PHP treats all to use the same instance!
            // First create our Calendar canvas for the range to display.
            $canvasStart = new \DateTime( $formatBug->format( 'Y-m-d' ) );
            $canvasEnd   = new \DateTime( $formatBug->format( 'Y-m-d' ) ); // End by the last day of the month "t"

            // Initialize our payment event
            $event = new \DateTime( $formatBug->format( 'Y-m-d' ) );
            $range = array( );

            switch( $data['payPeriod'] ) {
                case 'weekly' :
                    File::import( LIB . 'Util/Markaxis/Calendar/DayRecur.dll.php' );
                    File::import( LIB . 'Util/Markaxis/Calendar/WeekRecur.dll.php' );
                    $canvasEnd->modify('+3 weeks' );

                    $WeekRecur = new WeekRecur( $canvasStart->format( 'Y-m-d' ), $canvasEnd->format( 'Y-m-d' ) );
                    $event->modify('+1 week' );
                    $WeekRecur->setEvent( new Event( array( 'start' => $canvasStart->format( 'Y-m-d' ), 'end' => $event->format( 'Y-m-d' ),
                                                            'recurType' => 'week', 'endRecur' => 'never' ) ) );
                    $collections = $WeekRecur->getEvents( );

                    foreach( $collections as $collection ) {
                        $date = new \DateTime( $collection['start'] );
                        array_push( $range, $date->format('jS M') );
                    }
                    break;
                case 'biweekly' :
                    File::import( LIB . 'Util/Markaxis/Calendar/DayRecur.dll.php' );
                    File::import( LIB . 'Util/Markaxis/Calendar/WeekRecur.dll.php' );
                    $canvasEnd->modify('+1 month' );

                    $WeekRecur = new WeekRecur( $canvasStart->format( 'Y-m-d' ), $canvasEnd->format( 'Y-m-t' ) );
                    $event->modify('+1 weeks' );
                    $WeekRecur->setEvent( new Event( array( 'start' => $canvasStart->format( 'Y-m-d' ), 'end' => $event->format( 'Y-m-d' ),
                                                            'recurType' => 'week', 'endRecur' => 'never', 'repeatTimes' => 2 ) ) );
                    $collections = $WeekRecur->getEvents( );

                    foreach( $collections as $collection ) {
                        $date = new \DateTime( $collection['start'] );
                        array_push( $range, $date->format('jS M') );
                    }
                    break;
                case 'monthly' :
                    File::import( LIB . 'Util/Markaxis/Calendar/MonthRecur.dll.php' );

                    // Expand the canvas range by 3 months for display
                    $canvasEnd->modify('+3 months' );
                    $MonthRecur = new MonthRecur( $canvasStart->format( 'Y-m-d' ), $canvasEnd->format( 'Y-m-t' ) );

                    // If its month end, select all month end calendar date
                    if( $canvasStart->format( 'Y-m-t' ) == $canvasStart->format( 'Y-m-d' ) ) {
                        $MonthRecur->forceMonthEnd( true );
                    }

                    // Since this is a monthly, we shall add 1 month to this event.
                    ///$event->modify('+1 month' );
                    $MonthRecur->setEvent( new Event( array( 'start' => $canvasStart->format( 'Y-m-d' ), 'end' => $event->format( 'Y-m-d' ),
                                                             'recurType' => 'month', 'endRecur' => 'never', 'repeatTimes' => 1 ) ) );
                    $collections = $MonthRecur->getEvents( );
                    unset( $collections[0] );

                    foreach( $collections as $collection ) {
                        $date = new \DateTime( $collection['start'] );
                        array_push( $range, $date->format('jS M') );
                    }
                    break;
            }
            return $range;
        }
        return false;
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function savePayrun( $data ) {
        File::import(LIB . 'Util/Date.dll.php');
        File::import(LIB . 'Validator/Validator.dll.php');

        $this->info['pcID'] = (int)$data['pcID'];
        $this->info['calName'] = Validator::stripTrim( $data['calName'] );
        $this->info['startDate']   = \DateTime::createFromFormat( 'j F, Y', $data['startDate'] );
        $this->info['paymentDate'] = \DateTime::createFromFormat( 'j F, Y', $data['firstPayment'] );

        if( isset( RecurHelper::getL10nList( )[$data['payPeriod']] ) ) {
            $this->info['payPeriod'] = $data['payPeriod'];
        }

        $this->info['startDate']   = $this->info['startDate']->format('Y-m-d');
        $this->info['paymentDate'] = $this->info['paymentDate']->format('Y-m-d');

        File::import( DAO . 'Markaxis/Payroll/Calendar.class.php' );
        $Calendar = new Calendar( );

        if( $this->isFound( $this->info['pcID'] ) ) {
            $Calendar->update( 'pay_calendar', $this->info, 'WHERE pcID = "' . (int)$this->info['pcID'] . '"' );
        }
        else {
            $this->info['created'] = date( 'Y-m-d H:i:s' );
            $this->info['prID'] = $Calendar->insert('pay_calendar', $this->info );
        }
        return $this->info['pcID'];
    }
}
?>