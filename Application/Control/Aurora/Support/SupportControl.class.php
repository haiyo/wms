<?php
namespace Aurora\Support;
use \Markaxis\Employee\EmployeeModel;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: SupportControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class SupportControl {


    // Properties
    private $SupportModel;


    /**
     * LeaveApplyControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->SupportModel = new SupportModel( );
    }


    /**
     * For No Pay Leave
     * @return string
     */
    public function send( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST ) );

        if( $this->SupportModel->isValid( $post ) ) {
            $this->SupportModel->send( );
        }
        $vars = array( );
        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }


    /**
     * Upload Attachment
     * @return void
     */
    public function upload( ) {
        // COR not enabled
        //header('Access-Control-Allow-Origin: *');
        header( 'Access-Control-Allow-Credentials: true' );
        header( 'Pragma: no-cache' );
        header( 'Cache-Control: no-store, no-cache, must-revalidate' );
        header( 'X-Content-Type-Options: nosniff' );
        header( 'Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size' );

        $vars = array( );
        $vars['bool'] = 0;
        $file = Control::getRequest( )->request( FILES );

        if( $_SERVER['REQUEST_METHOD'] == 'POST' && empty( $_POST ) && empty( $_FILES ) &&
            $_SERVER['CONTENT_LENGTH'] > 0 ) {
            $vars['error'] = 'No files uploaded. Please make sure file size is within the allowed limit.';
        }
        else {
            if( $this->SupportModel->uploadSuccess( $file ) ) {
                $vars = $this->SupportModel->getFileInfo( );

                if( $vars['success'] == 2 ) {
                    unset( $vars['error'] );
                }
            }
            else {
                $vars['errMsg'] = $this->SupportModel->getErrMsg( );
            }
        }
        echo json_encode( $vars );
        exit;
    }
}
?>