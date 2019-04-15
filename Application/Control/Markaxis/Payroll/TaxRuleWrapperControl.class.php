<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TaxRuleWrapperControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxRuleWrapperControl {


    // Properties
    protected $TaxRuleWrapperView;


    /**
     * TaxRuleWrapperControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->TaxRuleWrapperView = new TaxRuleWrapperView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getTaxRule( $data ) {
        $vars = array( );
        $taxRule = Control::getOutputArray( );

        if( isset( $data[2] ) && $data[2] == 'html' ) {
            $vars['html'] = $this->TaxRuleWrapperView->renderTaxRule( $taxRule );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
        else {
            $vars['data'] = $taxRule;
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getAll( $data ) {
        $taxRules = Control::getOutputArray( );

        if( isset( $data[1] ) && $data[1] == 'html' ) {
            $vars['html'] = $this->TaxRuleWrapperView->renderAll( $taxRules );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
        else {
            echo json_encode( $taxRules );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveTaxRule( ) {
        $vars['data'] = Control::getPostData( );
        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }
}
?>