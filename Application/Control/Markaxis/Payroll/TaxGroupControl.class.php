<?php
namespace Markaxis\Payroll;
use \Library\IO\File;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TaxGroupControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxGroupControl {


    // Properties


    /**
     * TaxGroupControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getSelectList( ) {
        File::import( MODEL . 'Markaxis/Payroll/TaxGroupModel.class.php' );
        $TaxGroupModel = TaxGroupModel::getInstance( );
        echo json_encode( $TaxGroupModel->getSelectList( ) );
        exit;
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getTaxGroup( $data ) {
        if( isset( $data[1] ) ) {
            if( isset( $data[2] ) && $data[2] == 'html' ) {
                File::import(VIEW . 'Markaxis/Payroll/TaxGroupView.class.php');
                $TaxGroupView = new TaxGroupView( );
                $vars['html'] = $TaxGroupView->renderTaxGroup( $data[1] );
                $vars['bool'] = 1;
                echo json_encode($vars);
                exit;
            }
            else {
                File::import( MODEL . 'Markaxis/Payroll/TaxGroupModel.class.php' );
                $TaxGroupModel = TaxGroupModel::getInstance( );
                if( $data = $TaxGroupModel->getBytgID( $data[1] ) ) {
                    $vars['data'] = $data;
                    $vars['bool'] = 1;
                    echo json_encode( $vars );
                    exit;
                }
            }
        }
    }


    /**
     * Render main navigation
     * @return str
     */
    public function settings( ) {
        File::import( VIEW . 'Markaxis/Payroll/TaxGroupView.class.php' );
        $TaxGroupView = new TaxGroupView( );
        Control::setOutputArray( array( 'groupList' => $TaxGroupView->renderSettings( ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function saveTaxGroup( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );
        $vars['bool'] = 0;

        File::import( MODEL . 'Markaxis/Payroll/TaxGroupModel.class.php' );
        $TaxGroupModel = TaxGroupModel::getInstance( );

        if( $TaxGroupModel->saveTaxGroup( $post ) ) {
            $vars['data'] = $TaxGroupModel->getInfo( );
            $vars['bool'] = 1;
        }
        echo json_encode( $vars );
        exit;
    }
}
?>