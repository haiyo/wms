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
     * @return str
     */
    public function getItemResults( ) {
        $data = Control::getOutputArray( );
        echo json_encode( $this->ItemTaxModel->getItemResults( $data['list'] ) );
        exit;
    }
}
?>