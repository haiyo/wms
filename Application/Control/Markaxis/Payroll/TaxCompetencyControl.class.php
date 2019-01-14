<?php
namespace Markaxis\Payroll;
use \Library\IO\File;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TaxCompetencyControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxCompetencyControl {


    // Properties


    /**
     * TaxCompetencyControl Constructor
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
            File::import( MODEL . 'Markaxis/Payroll/TaxCompetencyModel.class.php' );
            $TaxCompetencyModel = TaxCompetencyModel::getInstance( );
            Control::setOutputArray( array( 'competency' => $TaxCompetencyModel->getTaxRule( $taxRule ) ) );
        }
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getAll( ) {
        $taxRules = Control::getOutputArray( );

        File::import( MODEL . 'Markaxis/Payroll/TaxCompetencyModel.class.php' );
        $TaxCompetencyModel = TaxCompetencyModel::getInstance( );
        Control::setOutputArray( $TaxCompetencyModel->getAll( $taxRules ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function saveTaxRule( ) {
        $post = Control::getPostData( );

        File::import( MODEL . 'Markaxis/Payroll/TaxCompetencyModel.class.php' );
        $TaxCompetencyModel = TaxCompetencyModel::getInstance( );
        $TaxCompetencyModel->saveTaxRule( $post );
    }
}
?>