<?php
namespace Markaxis\Payroll;
use \Library\IO\File;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CalendarControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CalendarControl {


    // Properties


    /**
     * CalendarControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function settings( ) {
        File::import( VIEW . 'Markaxis/Payroll/CalendarView.class.php' );
        $CalendarView = new CalendarView( );
        Control::setOutputArrayAppend( array( 'form' => $CalendarView->renderSettings( ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getCalResults( ) {
        $post = Control::getRequest( )->request( POST );

        File::import( MODEL . 'Markaxis/Payroll/CalendarModel.class.php' );
        $CalendarModel = CalendarModel::getInstance( );
        echo json_encode( $CalendarModel->getCalResults( $post ) );
        exit;
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getEndDate( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );

        File::import( VIEW . 'Markaxis/Payroll/CalendarView.class.php' );
        $CalendarView = new CalendarView( );
        $vars['data'] = $CalendarView->renderEndDate( $post );
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getPaymentRecur( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );

        File::import( VIEW . 'Markaxis/Payroll/CalendarView.class.php' );
        $CalendarView = new CalendarView( );
        $vars['data'] = $CalendarView->renderPaymentRecur( $post );
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return str
     */
    public function savePayrun( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );
        $vars['bool'] = 0;

        File::import( MODEL . 'Markaxis/Payroll/CalendarModel.class.php' );
        $CalendarModel = CalendarModel::getInstance( );

        if( $vars['data'] = $CalendarModel->savePayrun( $post ) ) {
            $vars['bool'] = 1;
        }
        echo json_encode( $vars );
        exit;
    }
}
?>