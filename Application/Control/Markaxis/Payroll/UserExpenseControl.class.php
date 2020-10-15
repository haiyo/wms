<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: UserExpenseControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserExpenseControl {


    // Properties
    protected $UserExpenseModel;


    /**
     * UserExpenseControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->UserExpenseModel = UserExpenseModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( ) {
        $data = Control::getOutputArray( );
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST ) );
        Control::setOutputArray( $this->UserExpenseModel->processPayroll( $data, $post ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function savePayroll( ) {
        $this->processPayroll( );
        Control::setOutputArray( $this->UserExpenseModel->savePayroll( Control::getOutputArray( ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function viewSaved( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( $this->UserExpenseModel->getExistingItems( $data ) );
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
    public function deletePayroll( ) {
        $data = Control::getOutputArray( );
        $this->UserExpenseModel->deletePayroll( $data );
    }
}
?>