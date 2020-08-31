<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TaxGroupControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxGroupControl {


    // Properties
    protected $TaxGroupModel;
    protected $TaxGroupView;


    /**
     * TaxGroupControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->TaxGroupModel = TaxGroupModel::getInstance( );
        $this->TaxGroupView = new TaxGroupView( );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getGroupList( ) {
        echo json_encode( $this->TaxGroupModel->getSelectList( ) );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getTaxGroup( $data ) {
        if( isset( $data[1] ) ) {
            if( isset( $data[2] ) && $data[2] == 'html' ) {
                $vars['html'] = $this->TaxGroupView->renderTaxGroup( $data[1] );
                $vars['bool'] = 1;
                echo json_encode($vars);
                exit;
            }
            else {
                if( $data = $this->TaxGroupModel->getBytgID( $data[1] ) ) {
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
     * @return string
     */
    public function settings( ) {
        Control::setOutputArray( array( 'groupList' => $this->TaxGroupView->renderSettings( ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveTaxGroup( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );
        $vars['bool'] = 0;

        if( $this->TaxGroupModel->saveTaxGroup( $post ) ) {
            $vars['data'] = $this->TaxGroupModel->getInfo( );
            $vars['bool'] = 1;
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deleteTaxGroup( ) {
        if( Control::hasPermission( 'Markaxis', 'add_modify_taxes' ) ) {
            $tgID = Control::getRequest( )->request( POST, 'tgID' );

            Control::setOutputArray( array( 'groupList' => $this->TaxGroupModel->delete( $tgID ) ) );
        }
    }
}
?>