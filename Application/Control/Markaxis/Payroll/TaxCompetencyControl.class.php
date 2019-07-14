<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TaxCompetencyControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxCompetencyControl {


    // Properties
    protected $TaxCompetencyModel;


    /**
     * TaxCompetencyControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->TaxCompetencyModel = TaxCompetencyModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getTaxRule( ) {
        $taxRule = Control::getOutputArray( );

        if( isset( $taxRule['trID'] ) ) {
            Control::setOutputArray( array( 'competency' => $this->TaxCompetencyModel->getTaxRule( $taxRule ) ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getAllTaxRules( ) {
        $taxRules = Control::getOutputArray( );
        Control::setOutputArray( $this->TaxCompetencyModel->getAll( $taxRules ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( $this->TaxCompetencyModel->processPayroll( $data ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function reprocessPayroll( ) {
        $this->processPayroll( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveTaxRule( ) {
        $post = Control::getPostData( );
        $this->TaxCompetencyModel->saveTaxRule( $post );
    }
}
?>