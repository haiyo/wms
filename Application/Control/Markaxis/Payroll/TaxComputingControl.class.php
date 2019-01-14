<?php
namespace Markaxis\Payroll;
use \Library\IO\File;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TaxComputingControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxComputingControl {


    // Properties


    /**
     * TaxComputingControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getTaxRule( $data ) {
        $taxRule = Control::getOutputArray( );

        if( isset( $taxRule['trID'] ) ) {
            if( isset( $data[2] ) && $data[2] == 'html' ) {
                File::import( VIEW . 'Markaxis/Payroll/TaxComputingView.class.php' );
                $TaxComputingView = new TaxComputingView( );
                Control::setOutputArray( array( 'computing' => $TaxComputingView->renderTaxRule( $taxRule ) ) );
            }
            else {
                File::import( MODEL . 'Markaxis/Payroll/TaxComputingModel.class.php' );
                $TaxComputingModel = TaxComputingModel::getInstance( );
                Control::setOutputArray( array( 'computing' => $TaxComputingModel->getBytrID( $taxRule['trID'] ) ) );
            }
        }
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getAll( ) {
        $taxRules = Control::getOutputArray( );

        File::import( VIEW . 'Markaxis/Payroll/TaxComputingView.class.php' );
        $TaxComputingView = new TaxComputingView( );
        Control::setOutputArray( $TaxComputingView->renderAll( $taxRules ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function saveTaxRule( ) {
        $post = Control::getPostData( );

        File::import( MODEL . 'Markaxis/Payroll/TaxComputingModel.class.php' );
        $TaxComputingModel = TaxComputingModel::getInstance( );
        $TaxComputingModel->saveTaxRule( $post );
    }
}
?>