<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: UserItemControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserItemControl {


    // Properties
    protected $UserItemModel;


    /**
     * UserItemControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->UserItemModel = UserItemModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function viewSaved( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( $this->UserItemModel->getExistingItems( $data ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function viewSlip( ) {
        $this->viewSaved( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( ) {
        $data = Control::getOutputArray( );
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST ) );
        Control::setOutputArray( $this->UserItemModel->processPayroll( $data, $post ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function savePayroll( ) {
        $this->processPayroll( );
        $this->UserItemModel->savePayroll( Control::getOutputArray( ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deletePayroll( ) {
        $data = Control::getOutputArray( );
        $this->UserItemModel->deletePayroll( $data );
    }
}
?>