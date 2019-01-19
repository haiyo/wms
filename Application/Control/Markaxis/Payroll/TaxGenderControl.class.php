<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TaxGenderControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxGenderControl {


    // Properties
    protected $TaxGenderModel;


    /**
     * TaxGenderControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->TaxGenderModel = TaxGenderModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getTaxRule( ) {
        $output = Control::getOutputArray( );

        if( isset( $output['trID'] ) ) {
            Control::setOutputArray( array( 'gender' => $this->TaxGenderModel->getBytrID( $output['trID'] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getAll( ) {
        $taxRules = Control::getOutputArray( );
        Control::setOutputArray( $this->TaxGenderModel->getAll( $taxRules ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function saveTaxRule( ) {
        $this->TaxGenderModel->saveTaxRule( Control::getPostData( ) );
    }
}
?>