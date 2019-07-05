<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: ItemTaxControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ItemTaxControl {


    // Properties
    protected $ItemTaxModel;


    /**
     * ItemTaxControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->ItemTaxModel = ItemTaxModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getItemResults( ) {
        $data = Control::getOutputArray( );

        if( isset( $data['list'] ) ) {
            echo json_encode( $this->ItemTaxModel->getItemResults( $data['list'] ) );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getPayItem( ) {
        $vars = array( );
        $data = Control::getOutputArray( );
        $data['taxGroups'] = $this->ItemTaxModel->getBypiID( $data['piID'] );

        $vars['data'] = $data;
        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function savePayItem( ) {
        $this->ItemTaxModel->save( Control::getPostData( ) );

        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }
}
?>