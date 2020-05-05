<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: PayslipControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayslipControl {


    // Properties
    protected $PayslipModel;
    protected $PayslipView;


    /**
     * PayslipControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->PayslipModel = PayslipModel::getInstance( );
        $this->PayslipView = new PayslipView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function view( ) {
        $this->PayslipView->renderPayslipList( );
    }


    /**
     * Render main navigation
     * @return void
     */
    public function getPayslipResults( ) {
        $post = Control::getRequest( )->request( POST );
        echo json_encode( $this->PayslipModel->getResults( $post ) );
        exit;
    }
}
?>