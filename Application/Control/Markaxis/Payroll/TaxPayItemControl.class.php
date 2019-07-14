<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TaxPayItemControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxPayItemControl {


    // Properties
    protected $TaxPayItemModel;
    protected $TaxPayItemView;


    /**
     * TaxComputingControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->TaxPayItemModel = TaxPayItemModel::getInstance( );
        $this->TaxPayItemView = new TaxPayItemView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getTaxRule( $data ) {
        $taxRule = Control::getOutputArray( );

        if( isset( $taxRule['trID'] ) ) {
            if( isset( $data[2] ) && $data[2] == 'html' ) {
                Control::setOutputArray( array( 'payItem' => $this->TaxPayItemView->renderTaxRule( $taxRule ) ) );
            }
            else {
                Control::setOutputArray( array( 'payItem' => $this->TaxPayItemModel->getBytrID( $taxRule['trID'] ) ) );
            }
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getAllTaxRules( ) {
        $taxRules = Control::getOutputArray( );
        Control::setOutputArray( $this->TaxPayItemView->renderAll( $taxRules ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( $this->TaxPayItemModel->processPayroll( $data ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function reprocessPayroll( ) {
        $data = Control::getOutputArray( );
        $post = Control::getPostData( );
        Control::setOutputArray( $this->TaxPayItemModel->reprocessPayroll( $data, $post ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function savePayroll( ) {
        $this->reprocessPayroll( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveTaxRule( ) {
        $post = Control::getPostData( );
        $this->TaxPayItemModel->saveTaxRule( $post );
    }
}
?>