<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TaxComputingControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxComputingControl {


    // Properties
    protected $TaxComputingModel;
    protected $TaxComputingView;


    /**
     * TaxComputingControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->TaxComputingModel = TaxComputingModel::getInstance( );
        $this->TaxComputingView = new TaxComputingView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getTaxRule( $data ) {
        $taxRule = Control::getOutputArray( );

        if( isset( $taxRule['trID'] ) ) {
            if( isset( $data[2] ) && $data[2] == 'html' ) {
                Control::setOutputArray( array( 'computing' => $this->TaxComputingView->renderTaxRule( $taxRule ) ) );
            }
            else {
                Control::setOutputArray( array( 'computing' => $this->TaxComputingModel->getBytrID( $taxRule['trID'] ) ) );
            }
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getAllTaxRules( ) {
        $taxRules = Control::getOutputArray( );
        Control::setOutputArray( $this->TaxComputingView->renderAll( $taxRules ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( $this->TaxComputingModel->processPayroll( $data ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function reprocessPayroll( ) {
        $data = Control::getOutputArray( );
        $post = Control::getPostData( );
        Control::setOutputArray( $this->TaxComputingModel->reprocessPayroll( $data, $post ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveTaxRule( ) {
        $post = Control::getPostData( );
        $this->TaxComputingModel->saveTaxRule( $post );
    }
}
?>