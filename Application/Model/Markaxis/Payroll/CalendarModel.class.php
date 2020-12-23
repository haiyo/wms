<?php
namespace Markaxis\Payroll;
use \Markaxis\Employee\PayrollModel AS EmpPayrollModel;
use \Library\Util\Markaxis\Calendar\WeekRecur;
use \Library\Util\Markaxis\Calendar\MonthRecur;
use \Library\Helper\Markaxis\RecurHelper;
use \Library\Util\Markaxis\Calendar\Event;
use \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: CalendarModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarModel extends \Model {


    // Properties
    private $Calendar;



    /**
     * CalendarModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->Calendar = new Calendar( );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function isFoundBypcID( $pcID ) {
        return $this->Calendar->isFoundBypcID( $pcID );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getBypcID( $pcID ) {
        return $this->Calendar->getBypcID( $pcID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getList( ) {
        return $this->Calendar->getList( );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getCalResults( $data ) {
        $this->Calendar->setLimit( $data['start'], $data['length'] );

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

        $results = $this->Calendar->getCalResults( $data['search']['value'], $order . $dir );

        foreach( $results as $key => $value ) {
            // Prevent running into recordsTotal
            if( isset( $value['paymentDate'] ) ) {
                $paymentDate = explode('-', $value['paymentDate'] );
                $value['paymentDate'] = date('j F, Y', mktime(0,0,0, date('m'), $paymentDate[2], date('Y') ) );

                $results[$key]['paymentCycle'] = implode(', ', $this->getPaymentRecur( $value ) );
            }
        }

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
                case 'week' :
                    $startDate->modify('+1 week' );
                    break;
                case 'biweekly' :
                    $startDate->modify('+2 week' );
                    break;
                case 'monthly' :
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
        if( isset( $data['paymentDate'] ) && isset( $data['payPeriod'] ) ) {
            // A bug related to @https://stackoverflow.com/questions/17785443/strtotime-and-datetime-giving-wrong-year-when-parsing-a-year
            // Datetime and strtotime is producing WRONG YEAR! We now use createFromFormat() to more accurately match the format we received
            // from the UI calendar.
            $formatBug = \DateTime::createFromFormat('j F, Y', $data['paymentDate'] );
            if( !$formatBug ) return false;

            // Don't use shorthand assign here as PHP treats all to use the same instance!
            // First create our Calendar canvas for the range to display.
            $canvasStart = new \DateTime( $formatBug->format( 'Y-m-d' ) );
            $canvasEnd   = new \DateTime( $formatBug->format( 'Y-m-d' ) ); // End by the last day of the month "t"

            // Initialize our payment event
            $event = new \DateTime( $formatBug->format( 'Y-m-d' ) );
            $range = array( );

            switch( $data['payPeriod'] ) {
                case 'week' :
                    $canvasEnd->modify('+2 week' );

                    $WeekRecur = new WeekRecur( $canvasStart->format( 'Y-m-d' ), $canvasEnd->format( 'Y-m-d' ) );
                    $event->modify('+1 weeks' );

                    //echo $canvasStart->format( 'Y-m-d' ) . ' = ' . $event->format( 'Y-m-d' );

                    $WeekRecur->setEvent( new Event( array( 'start' => $canvasStart->format( 'Y-m-d' ),
                                                            'end' => $event->format( 'Y-m-d' ),
                                                            'recurType' => 'week',
                                                            'endRecur' => 'never' ) ) );
                    $collections = $WeekRecur->getEvents( );

                    foreach( $collections as $collection ) {
                        $date = new \DateTime( $collection['start'] );
                        array_push( $range, $date->format('jS M') );
                    }
                    break;
                case 'biweekly' :
                    $canvasEnd->modify('+2 weeks' );

                    $WeekRecur = new WeekRecur( $canvasStart->format( 'Y-m-d' ), $canvasEnd->format( 'Y-m-t' ) );
                    $event->modify('+1 weeks' );
                    $WeekRecur->setEvent( new Event( array( 'start' => $canvasStart->format( 'Y-m-d' ),
                                                            'end' => $event->format( 'Y-m-d' ),
                                                            'recurType' => 'week',
                                                            'endRecur' => 'never',
                                                            'repeatTimes' => 2 ) ) );
                    $collections = $WeekRecur->getEvents( );

                    foreach( $collections as $collection ) {
                        $date = new \DateTime( $collection['start'] );
                        array_push( $range, $date->format('jS M') );
                    }
                    break;
                case 'month' :
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
     * Return total count of records
     * @return int
     */
    public function getPayCal( $data ) {
        // Get employee pay calendar
        $EmpPayrollModel = EmpPayrollModel::getInstance( );

        $payCalInfo = $EmpPayrollModel->getByUserID( $data['empInfo']['userID'], 'payPeriod, paymentDate' );

        // Get pay calendar day
        $payCalDay = explode('-', $payCalInfo['paymentDate'] )[2];

        // Convert all to DateTime obj and get this month end payroll range date
        $payCalInfo['processDate'] = new \DateTime( $data['payrollInfo']['startDate'] );
        $payCalInfo['paymentDate'] = new \DateTime( $payCalInfo['paymentDate'] );
        $payCalInfo['rangeEnd']    = new \DateTime( $payCalInfo['processDate']->format('Y-m-') . $payCalDay . ' 23:59:59' );

        $payCalInfo['rangeStart'] = clone $payCalInfo['rangeEnd'];
        $payCalInfo['rangeStart']->modify('-1 month');

        return $payCalInfo;
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function updatePayPeriod( ) {
        $results = $this->Calendar->getCalResults( );
        $sizeof  = sizeof( $results );
        $currDate = new \DateTime( );

        for( $i=0; $i<$sizeof; $i++ ) {
            if( isset( $results[$i] ) ) {
                switch( $results[$i]['payPeriod'] ) {
                    case 'weekly' :
                        // Setup canvas for NOW to next week
                        $nextWeek = new \DateTime( );
                        $nextWeek = $nextWeek->modify('+1 week');

                        $WeekRecur = new WeekRecur( $currDate->format( 'Y-m-d' ), $nextWeek->format( 'Y-m-d' ) );

                        $startEvent = new \DateTime( $results[$i]['startDate'] );
                        $endEvent = new \DateTime( $results[$i]['startDate'] );

                        $WeekRecur->setEvent( new Event( array( 'start' => $startEvent->format( 'Y-m-d' ),
                                                                'end' => $endEvent->format( 'Y-m-d' ),
                                                                'recurType' => 'week', 'endRecur' => 'never' ) ) );

                        $collections = $WeekRecur->getEvents( );
                        $collections = array_slice( $collections, -2, 2, true );
                        $collections = array_values( $collections );

                        if( isset( $collections[0] ) && isset( $collections[1] ) ) {
                            $nextStart = new \DateTime( $collections[0]['start'] );
                            $nextEnd = new \DateTime( $collections[1]['end'] );

                            $info = array( );
                            $info['startDate'] = $nextStart->format( 'Y-m-d' );
                            $info['paymentDate'] = $nextEnd->format( 'Y-m-d' );
                            $this->Calendar->update( 'pay_calendar', $info, 'WHERE pcID = "' . (int)$results[$i]['pcID'] . '"' );
                        }
                        break;
                    case 'monthly' :
                        $MonthRecur = new MonthRecur( $currDate->format( 'Y-m-01' ), $currDate->format( 'Y-m-t' ) );

                        $startEvent = new \DateTime( $results[$i]['startDate'] );
                        $endEvent = MonthRecur::addMonth( $startEvent, $startEvent );

                        $event = new Event( array( 'start' => $startEvent->format( 'Y-m-d' ),
                                                   'end' => $endEvent->format( 'Y-m-d' ),
                                                   'recurType' => 'month',
                                                   'endRecur' => 'never',
                                                   'repeatTimes' => 1 ) );

                        $MonthRecur->setEvent( $event );
                        $collections = $MonthRecur->getEvents( );

                        if( isset( $collections[0] ) ) {
                            $nextStart = new \DateTime( $collections[0]['start'] );
                            $nextEnd = new \DateTime( $collections[0]['end'] );

                            $info = array( );
                            $info['startDate'] = $nextStart->format( 'Y-m-d' );
                            $info['paymentDate'] = $nextEnd->format( 'Y-m-d' );
                            $this->Calendar->update( 'pay_calendar', $info, 'WHERE pcID = "' . (int)$results[$i]['pcID'] . '"' );
                        }
                        break;
                }
            }
        }
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function savePayCal( $data ) {
        $this->info['pcID'] = (int)$data['pcID'];
        $this->info['title'] = Validator::stripTrim( $data['title'] );
        $this->info['paymentDate'] = \DateTime::createFromFormat( 'j F, Y', $data['paymentDate'] );

        if( isset( RecurHelper::getL10nList( )[$data['payPeriod']] ) ) {
            $this->info['payPeriod'] = $data['payPeriod'];
        }
        $this->info['paymentDate'] = $this->info['paymentDate']->format('Y-m-d');

        if( $this->isFoundBypcID( $this->info['pcID'] ) ) {
            $this->Calendar->update( 'pay_calendar', $this->info, 'WHERE pcID = "' . (int)$this->info['pcID'] . '"' );
        }
        else {
            $this->info['created'] = date( 'Y-m-d H:i:s' );
            $this->info['pcID'] = $this->Calendar->insert('pay_calendar', $this->info );
        }
        return $this->info['pcID'];
    }


    /**
     * Return total count of records
     * @return int
     */
    public function deletePayCal( $data ) {
        if( isset( $data['pcID'] ) ) {
            return $this->Calendar->delete('pay_calendar','WHERE pcID = "' . (int)$data['pcID'] . '"');
        }
    }
}
?>