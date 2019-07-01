<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TaxDesignationControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxDesignationControl {


    // Properties
    protected $TaxDesignationModel;


    /**
     * TaxDesignationControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->TaxDesignationModel = TaxDesignationModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getTaxRule( ) {
        $taxRule = Control::getOutputArray( );

        if( isset( $taxRule['trID'] ) ) {
            Control::setOutputArray( array( 'designation' => $this->TaxDesignationModel->getBytrID( $taxRule['trID'] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getAllTaxRules( ) {
        $taxRules = Control::getOutputArray( );
        Control::setOutputArray( $this->TaxDesignationModel->getAll( $taxRules ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveTaxRule( ) {
        $this->TaxDesignationModel->saveTaxRule( Control::getPostData( ) );
    }
}
?>