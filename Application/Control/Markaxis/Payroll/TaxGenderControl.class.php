<?php
namespace Markaxis\Payroll;
use \Library\IO\File;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TaxGenderControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxGenderControl {


    // Properties


    /**
     * TaxGenderControl Constructor
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
        $output = Control::getOutputArray( );

        if( isset( $output['trID'] ) ) {
            File::import( MODEL . 'Markaxis/Payroll/TaxGenderModel.class.php' );
            $TaxGenderModel = TaxGenderModel::getInstance( );
            Control::setOutputArray( array( 'gender' => $TaxGenderModel->getBytrID( $output['trID'] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getAll( ) {
        $taxRules = Control::getOutputArray( );

        File::import( MODEL . 'Markaxis/Payroll/TaxGenderModel.class.php' );
        $TaxGenderModel = TaxGenderModel::getInstance( );
        Control::setOutputArray( $TaxGenderModel->getAll( $taxRules ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function saveTaxRule( ) {
        File::import( MODEL . 'Markaxis/Payroll/TaxGenderModel.class.php' );
        $TaxGenderModel = TaxGenderModel::getInstance( );
        $TaxGenderModel->saveTaxRule( Control::getPostData( ) );
    }
}
?>