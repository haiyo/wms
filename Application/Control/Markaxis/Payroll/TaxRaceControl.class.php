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


    /**
     * TaxRaceControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->TaxRaceModel = TaxRaceModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getTaxRule( ) {
        $taxRule = Control::getOutputArray( );

        if( isset( $taxRule['trID'] ) ) {
            Control::setOutputArray( array( 'race' => $this->TaxRaceModel->getBytrID( $taxRule['trID'] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getAll( ) {
        $taxRules = Control::getOutputArray( );
        Control::setOutputArray( $this->TaxRaceModel->getAll( $taxRules ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( $args ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( $this->TaxRaceModel->processPayroll( $args[1], $data ) );
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