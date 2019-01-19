<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TaxContractControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxContractControl {


    // Properties
    protected $TaxContractModel;


    /**
     * TaxContractControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->TaxContractModel = TaxContractModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getTaxRule( ) {
        $taxRule = Control::getOutputArray( );

        if( isset( $taxRule['trID'] ) ) {
            Control::setOutputArray( array( 'contract' => $this->TaxContractModel->getBytrID( $taxRule['trID'] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getAll( ) {
        $taxRules = Control::getOutputArray( );
        Control::setOutputArray( $this->TaxContractModel->getAll( $taxRules ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function saveTaxRule( ) {
        $this->TaxContractModel->saveTaxRule( Control::getPostData( ) );
    }
}
?>