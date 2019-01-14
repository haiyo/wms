<?php
namespace Markaxis\Payroll;
use \Library\IO\File;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TaxRuleControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxRuleControl {


    // Properties


    /**
     * TaxRuleControl Constructor
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
        if( isset( $data[1] ) ) {
            File::import(MODEL . 'Markaxis/Payroll/TaxRuleModel.class.php');
            $TaxRuleModel = new TaxRuleModel( );
            Control::setOutputArray( $TaxRuleModel->getBytrID( $data[1] ) );
        }
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getAll( ) {
        File::import(MODEL . 'Markaxis/Payroll/TaxRuleModel.class.php');
        $TaxRuleModel = new TaxRuleModel( );
        Control::setOutputArray( $TaxRuleModel->getAll( ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function saveTaxRule( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );
        $vars = array( );

        File::import( MODEL . 'Markaxis/Payroll/TaxRuleModel.class.php' );
        $TaxRuleModel = TaxRuleModel::getInstance( );

        if( $post['trID'] = $TaxRuleModel->saveTaxRule( $post ) ) {
            Control::setPostData( $post );
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $TaxRuleModel->getErrMsg( );
            echo json_encode( $vars );
            exit;
        }
    }
}
?>