<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: LevyControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LevyControl {


    // Properties
    protected $LevyModel;


    /**
     * LevyControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->LevyModel = LevyModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getChart( ) {
        $data = Control::getOutputArray( );

        if( isset( $data['data']['dateStart'] ) ) {
            Control::setOutputArrayAppend( array( 'data' => $this->LevyModel->getChart( $data['data'] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function viewSaved( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( array( 'levies' => $this->LevyModel->getExistingLevies( $data ) ) );
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
        $this->LevyModel->savePayroll( $data );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deletePayroll( ) {
        $data = Control::getOutputArray( );
        $this->LevyModel->deletePayroll( $data );
    }
}
?>