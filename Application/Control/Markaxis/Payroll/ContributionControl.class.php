<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: ContributionControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ContributionControl {


    // Properties
    protected $ContributionModel;


    /**
     * ContributionControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->ContributionModel = ContributionModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getChart( ) {
        $data = Control::getOutputArray( );

        if( isset( $data['data']['dateStart'] ) ) {
            Control::setOutputArrayAppend( array( 'data' => $this->ContributionModel->getChart( $data['data'] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function viewSaved( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( array( 'contributions' => $this->ContributionModel->getExistingContributions( $data ) ) );
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
        $this->ContributionModel->savePayroll( $data );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deletePayroll( ) {
        $data = Control::getOutputArray( );
        $this->ContributionModel->deletePayroll( $data );
    }
}
?>