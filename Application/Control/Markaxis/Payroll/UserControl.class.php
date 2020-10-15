<?php
namespace Markaxis\Payroll;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: UserControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserControl {


    // Properties
    protected $UserModel;


    /**
     * UserControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->UserModel = UserModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( array( 'payrollUser' => $this->UserModel->getUserPayroll( $data['payrollInfo']['pID'], $data['empInfo']['userID'] ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function viewSlip( ) {
        $this->processPayroll( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function viewSaved( ) {
        $this->processPayroll( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function savePayroll( ) {
        $this->UserModel->savePayroll( Control::getOutputArray( ) );
        $this->processPayroll( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deletePayroll( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( array( 'puID' => $this->UserModel->deletePayroll( $data ),
                                        'userProcessCount' => $this->UserModel->isFound( $data ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function release( ) {
        if( Control::hasPermission( 'Markaxis', 'process_payroll' ) ) {
            $post = Control::getDecodedArray( Control::getRequest( )->request( POST ) );

            if( $vars['count'] = $this->UserModel->release( $post ) ) {
                $vars['bool'] = 1;
            }
            else {
                $vars['bool'] = 0;
                $vars['errMsg'] = $this->UserModel->getErrMsg( );
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
            $this->UserModel->releaseAll( $post );

            $vars = array( );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
    }
}
?>