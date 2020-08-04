<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: PayrollUserControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollUserControl {


    // Properties
    protected $PayrollUserModel;


    /**
     * PayrollUserControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->PayrollUserModel = PayrollUserModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function savePayroll( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( array( 'puID' => $this->PayrollUserModel->savePayroll( $data ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deletePayroll( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( array( 'puID' => $this->PayrollUserModel->deletePayroll( $data ),
                                        'userProcessCount' => $this->PayrollUserModel->isFound( $data ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function release( ) {
        if( Control::hasPermission( 'Markaxis', 'process_payroll' ) ) {
            $post = Control::getDecodedArray( Control::getRequest( )->request( POST ) );

            if( $vars['count'] = $this->PayrollUserModel->release( $post ) ) {
                $vars['bool'] = 1;
            }
            else {
                $vars['bool'] = 0;
                $vars['errMsg'] = $this->PayrollUserModel->getErrMsg( );
            }
            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function releaseAll( ) {
        if( Control::hasPermission( 'Markaxis', 'process_payroll' ) ) {
            $post = Control::getDecodedArray( Control::getRequest( )->request( POST ) );
            $this->PayrollUserModel->releaseAll( $post );

            $vars = array( );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
    }
}
?>