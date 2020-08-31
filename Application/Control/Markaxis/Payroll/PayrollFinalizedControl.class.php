<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: PayrollFinalizedControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollFinalizedControl {


    // Properties
    protected $PayrollFinalizedModel;
    protected $PayrollFinalizedView;


    /**
     * PayrollFinalizedControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->PayrollFinalizedModel = PayrollFinalizedModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getAllFinalized( $args ) {
        // processDate && officeID
        if( isset( $args[1] ) && isset( $args[2] ) ) {
            $post = Control::getRequest( )->request( POST );
            echo json_encode( $this->PayrollFinalizedModel->getResults( $post, $args[1], $args[2] ) );
            exit;
        }
    }
}
?>