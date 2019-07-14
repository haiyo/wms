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
    public function savePayrun( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );
        $vars['bool'] = 0;

        if( $vars['data'] = $this->CalendarModel->savePayrun( $post ) ) {
            $vars['bool'] = 1;
        }
        echo json_encode( $vars );
        exit;
    }
}
?>