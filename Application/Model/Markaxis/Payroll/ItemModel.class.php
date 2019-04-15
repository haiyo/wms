<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ItemModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ItemModel extends \Model {


    // Properties
    protected $Item;



    /**
     * ItemModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->Item = new Item( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $piID ) {
        return $this->Item->isFound( $piID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->Item->getList( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getBypiID( $piID ) {
        return $this->Item->getBypiID( $piID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getBasicID( ) {
        return $this->Item->getBasicID( );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getItemResults( $data ) {
        $this->Item->setLimit( $data['start'], $data['length'] );

        $order = 'pi.title';
        $dir   = isset( $data['order'][0]['dir'] ) && $data['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $data['order'][0]['column'] ) ) {
            switch( $data['order'][0]['column'] ) {
                case 1:
                    $order = 'pi.title';
                    break;
                case 2:
                    $order = 'pi.basic';
                    break;
                case 3:
                    $order = 'pi.deduction';
                    break;
            }
        }

        $results = $this->Item->getItemResults( $data['search']['value'], $order . $dir );
        $sizeof  = sizeof( $results );

        /*for( $i=0; $i<$sizeof; $i++ ) {
            if( isset( $results[$i] ) ) {
                switch( $results[$i]['payPeriod'] ) {
                    case 'weekly' :
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
                }
                $results[$i]['payPeriod'] = ucwords( $results[$i]['payPeriod'] );
            }
        }*/

        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$data['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }
}
?>