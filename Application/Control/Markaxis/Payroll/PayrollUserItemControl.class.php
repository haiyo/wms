<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: PayrollUserItemControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollUserItemControl {


    // Properties
    protected $PayrollUserItemModel;


    /**
     * PayrollUserControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->PayrollUserItemModel = PayrollUserItemModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function savePayroll( ) {
        $data = Control::getOutputArray( );
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST ) );
        $this->PayrollUserItemModel->savePayroll( $data, $post );
    }
}
?>