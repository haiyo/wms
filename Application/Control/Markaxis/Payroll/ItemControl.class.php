<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: ItemControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ItemControl {


    // Properties
    protected $ItemModel;
    protected $ItemView;


    /**
     * ItemControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->ItemModel = ItemModel::getInstance( );
        $this->ItemView = new ItemView( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function settings( ) {
        Control::setOutputArrayAppend( array( 'form' => $this->ItemView->renderSettings( ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getItemResults( ) {
        $post = Control::getRequest( )->request( POST );
        Control::setOutputArray( array( 'list' => $this->ItemModel->getItemResults( $post ) ) );
    }


    /**
     * Render main navigation
     * @return str
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
     * @return str
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
     * @return str
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