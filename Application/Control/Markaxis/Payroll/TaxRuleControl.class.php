<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TaxRuleControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxRuleControl {


    // Properties
    protected $TaxRuleModel;


    /**
     * TaxRuleControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->TaxRuleModel = new TaxRuleModel( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getTaxRule( $data ) {
        if( isset( $data[1] ) ) {
            Control::setOutputArray( $this->TaxRuleModel->getBytrID( $data[1] ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getAllTaxRules( ) {
        Control::setOutputArray( $this->TaxRuleModel->getAll( ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( $this->TaxRuleModel->getProcessTaxRules( $data ) );
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
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );
        $vars = array( );

        if( $post['trID'] = $this->TaxRuleModel->saveTaxRule( $post ) ) {
            Control::setPostData( $post );
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->TaxRuleModel->getErrMsg( );
            echo json_encode( $vars );
            exit;
        }
    }
}
?>