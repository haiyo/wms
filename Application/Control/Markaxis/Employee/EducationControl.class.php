<?php
namespace Markaxis\Employee;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: EducationControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EducationControl {


    // Properties
    private $EducationModel;


    /**
     * EducationControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->EducationModel = EducationModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function view( ) {
        $EmployeeView = new EmployeeView( );
        echo $EmployeeView->renderEdit( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function add( ) {
        $EducationView = new EducationView( );
        Control::setOutputArrayAppend( array( 'form' => $EducationView->renderAdd( ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function edit( $args ) {
        $userID = isset( $args[1] ) ? (int)$args[1] : 0;

        $EducationView = new EducationView( );
        Control::setOutputArrayAppend( array( 'form' => $EducationView->renderEdit( $userID ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function save( ) {
        $this->EducationModel->save( Control::getPostData( ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deleteEducation( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );
        $vars['bool'] = 0;

        if( $this->EducationModel->deleteEducation( $post ) ) {
            $vars['bool'] = 1;
        }
        else {
            $vars['errMsg'] = $this->EducationModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Upload Attachment
     * @return void
     */
    public function uploadCertificate( ) {
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
            if( $this->EducationModel->uploadSuccess( $file ) ) {
                $vars = $this->EducationModel->getFileInfo( );

                if( $vars['success'] == 2 ) {
                    unset( $vars['error'] );
                }
            }
            else {
                $vars['errMsg'] = $this->EducationModel->getErrMsg( );
            }
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function updateCertificate( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );
        $vars['bool'] = 0;

        if( $this->EducationModel->updateCertificate( $post ) ) {
            $vars['bool'] = 1;
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deleteCertificate( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );
        $vars['bool'] = 0;

        if( $this->EducationModel->deleteCertificate( $post ) ) {
            $vars['bool'] = 1;
        }
        else {
            $vars['errMsg'] = $this->EducationModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }
}
?>