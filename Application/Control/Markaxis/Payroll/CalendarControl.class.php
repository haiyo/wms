<?php
namespace Markaxis\Payroll;
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
    public function settings( ) {
        Control::setOutputArrayAppend( array( 'form' => $this->CalendarView->renderSettings( ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getCalResults( ) {
        $post = Control::getRequest( )->request( POST );

        echo json_encode( $this->CalendarModel->getCalResults( $post ) );
        exit;
    }

    /**
     * Render main navigation
     * @return string
     */
    public function getPayCal( $data ) {
        if( isset( $data[1] ) ) {
            $vars = array( );
            $vars['data'] = $this->CalendarModel->getBypcID( $data[1] );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getEndDate( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );

        $vars['data'] = $this->CalendarView->renderEndDate( $post );
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getPaymentRecur( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );

        $vars['data'] = $this->CalendarView->renderPaymentRecur( $post );
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( $args ) {
        if( isset( $args[2] ) ) {
            $data = Control::getOutputArray( );
            Control::setOutputArray( $this->CalendarModel->getEmployeeDuration( $args[2], $data ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function updatePayPeriod( ) {
        $this->CalendarModel->updatePayPeriod( );
        echo 'ok';
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function savePayCal( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );
        $vars['bool'] = 0;

        if( $vars['data'] = $this->CalendarModel->savePayCal( $post ) ) {
            $vars['bool'] = 1;
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deletePayCal( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );
        $vars['bool'] = 0;

        if( $this->CalendarModel->deletePayCal( $post ) ) {
            $vars['bool'] = 1;
        }
        else {
            $vars['errMsg'] = $this->CalendarModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }
}
?>