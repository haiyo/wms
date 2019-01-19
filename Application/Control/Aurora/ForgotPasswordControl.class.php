<?php
namespace Aurora;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, July 4th, 2012
 * @version $Id: ForgotPasswordControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ForgotPasswordControl {


    // Properties


    /**
    * ForgotPasswordControl Constructor
    * @return void
    */
    function __construct( ) {
        //
    }


    /**
     * Display login
     * @return void
     */
    public function forgotPassword( $data ) {
        $ForgotPasswordModel = ForgotPasswordModel::getInstance( );

        if( isset( $data[0] ) && isset( $data[1] ) ) {
            if( $data[0] == 'token' ) {
                if( $info = $ForgotPasswordModel->isValidToken( $data[1] ) ) {
                    $ForgotPasswordView = ForgotPasswordView::getInstance( );
                    $ForgotPasswordView->printAll( $ForgotPasswordView->renderChangePassword( $data[1] ) );
                    exit;
                }
            }
        }
        else {
            $email = Control::getRequest( )->request( POST, 'email' );
            $vars = array( );

            if( $ForgotPasswordModel->sendForgotPasswordLink( $email ) ) {
                $vars['bool'] = 1;
            }
            else {
                $vars['bool'] = 0;
                $vars['errMsg'] = $ForgotPasswordModel->getErrMsg( );
            }
            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Display login
     * @return void
     */
    public function changePassword( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );

        $ForgotPasswordModel = ForgotPasswordModel::getInstance( );

        if( $ForgotPasswordModel->changePassword( $post ) ) {
            $vars['bool'] = 1;
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $ForgotPasswordModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }
}
?>