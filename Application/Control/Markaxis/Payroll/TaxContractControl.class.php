<?php
namespace Markaxis\Payroll;
use \Library\IO\File;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TaxContractControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxContractControl {


    // Properties


    /**
     * TaxContractControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getTaxRule( ) {
        $taxRule = Control::getOutputArray( );

        if( isset( $taxRule['trID'] ) ) {
            File::import( MODEL . 'Markaxis/Payroll/TaxContractModel.class.php' );
            $TaxContractModel = TaxContractModel::getInstance( );
            Control::setOutputArray( array( 'contract' => $TaxContractModel->getBytrID( $taxRule['trID'] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getAll( ) {
        $taxRules = Control::getOutputArray( );

        File::import( MODEL . 'Markaxis/Payroll/TaxContractModel.class.php' );
        $TaxContractModel = TaxContractModel::getInstance( );
        Control::setOutputArray( $TaxContractModel->getAll( $taxRules ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function saveTaxRule( ) {
        File::import( MODEL . 'Markaxis/Payroll/TaxContractModel.class.php' );
        $TaxContractModel = TaxContractModel::getInstance( );
        $TaxContractModel->saveTaxRule( Control::getPostData( ) );
    }
}
?>