<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TaxRaceControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxRaceControl {


    // Properties
    protected $TaxRaceModel;
    protected $TaxRaceView;


    /**
     * TaxRaceControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->TaxRaceModel = TaxRaceModel::getInstance( );
        $this->TaxRaceView = new TaxRaceView( );
    }



    /**
     * Render main navigation
     * @return string
     */
    public function getTaxRule( $data ) {
        $taxRule = Control::getOutputArray( );

        if( isset( $taxRule['trID'] ) ) {
            if( isset( $data[2] ) && $data[2] == 'html' ) {
                Control::setOutputArray( array( 'race' => $this->TaxRaceView->renderTaxRule( $taxRule ) ) );
            }
            else {
                Control::setOutputArray( array( 'race' => $this->TaxRaceModel->getBytrID( $taxRule['trID'] ) ) );
            }
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getAllTaxRules( ) {
        $taxRules = Control::getOutputArray( );
        Control::setOutputArray( $this->TaxRaceView->renderAll( $taxRules ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( $this->TaxRaceModel->processPayroll( $data ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function reprocessPayroll( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( $this->TaxRaceModel->processPayroll( $data ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveTaxRule( ) {
        $this->TaxRaceModel->saveTaxRule( Control::getPostData( ) );
    }
}
?>