<?php
namespace Markaxis\Payroll;
use \Library\IO\File;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TaxDesignationControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxDesignationControl {


    // Properties


    /**
     * TaxDesignationControl Constructor
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
            File::import( MODEL . 'Markaxis/Payroll/TaxDesignationModel.class.php' );
            $TaxDesignationModel = TaxDesignationModel::getInstance( );
            Control::setOutputArray( array( 'designation' => $TaxDesignationModel->getBytrID( $taxRule['trID'] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getAll( ) {
        $taxRules = Control::getOutputArray( );

        File::import( MODEL . 'Markaxis/Payroll/TaxDesignationModel.class.php' );
        $TaxDesignationModel = TaxDesignationModel::getInstance( );
        Control::setOutputArray( $TaxDesignationModel->getAll( $taxRules ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function saveTaxRule( ) {
        File::import( MODEL . 'Markaxis/Payroll/TaxDesignationModel.class.php' );
        $TaxDesignationModel = TaxDesignationModel::getInstance( );
        $TaxDesignationModel->saveTaxRule( Control::getPostData( ) );
    }
}
?>