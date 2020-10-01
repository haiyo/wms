<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: UserTaxControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserTaxControl {


    // Properties
    protected $UserTaxModel;


    /**
     * UserTaxControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->UserTaxModel = UserTaxModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function viewSaved( ) {
        $data = Control::getOutputArray( );

        if( isset( $data['payrollUser']['puID'] ) ) {
            Control::setOutputArray( array( 'userTax' => $this->UserTaxModel->getByPuID( $data['payrollUser']['puID'] ) ) );
        }
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
    public function savePayroll( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( $this->UserTaxModel->savePayroll( $data ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deletePayroll( ) {
        $data = Control::getOutputArray( );
        $this->UserTaxModel->deletePayroll( $data );
    }
}
?>