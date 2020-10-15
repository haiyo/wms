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
     * @return string
     */
    public function settings( ) {
        Control::setOutputArrayAppend( array( 'form' => $this->ItemView->renderSettings( ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getItemResults( ) {
        $post = Control::getRequest( )->request( POST );
        echo json_encode( $this->ItemModel->getResults( $post ) );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getPayItem( $data ) {
        if( isset( $data[1] ) ) {
            $vars = array( );
            $vars['data'] = $this->ItemModel->getBypiID( $data[1] );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( $this->ItemModel->getAllItems( $data, false ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function recalculate( ) {
        $this->processPayroll( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function viewSaved( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( $this->ItemModel->getAllItems( $data, true ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function viewSlip( ) {
        $this->processPayroll( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function savePayroll( ) {
        $this->processPayroll( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function savePayItem( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );

        if( $this->ItemModel->isValid( $post ) ) {
            $post['piID'] = $this->ItemModel->save( );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->ItemModel->getErrMsg( );
            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deletePayItem( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );

        if( $vars['count'] = $this->ItemModel->delete( $post ) ) {
            $vars['bool'] = 1;
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->ItemModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }
}
?>