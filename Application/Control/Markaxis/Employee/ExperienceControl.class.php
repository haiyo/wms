<?php
namespace Markaxis\Employee;
use \Library\IO\File;
use \Control;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: ExperienceControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ExperienceControl {


    // Properties
    private $ExperienceModel;


    /**
     * ExperienceControl Constructor
     * @return void
     */
    function __construct( ) {
        File::import( MODEL . 'Markaxis/Employee/ExperienceModel.class.php' );
        $this->ExperienceModel = ExperienceModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function view( ) {
        File::import( VIEW . 'Markaxis/Employee/EmployeeView.class.php' );
        $EmployeeView = new EmployeeView( );
        echo $EmployeeView->renderEdit( );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function add( ) {
        File::import( VIEW . 'Markaxis/Employee/ExperienceView.class.php' );
        $ExperienceView = new ExperienceView( );
        Control::setOutputArrayAppend( array( 'form' => $ExperienceView->renderAdd( ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function edit( $args ) {
        $userID = isset( $args[1] ) ? (int)$args[1] : 0;

        File::import( VIEW . 'Markaxis/Employee/ExperienceView.class.php' );
        $ExperienceView = new ExperienceView( );
        Control::setOutputArrayAppend( array( 'form' => $ExperienceView->renderEdit( $userID ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function save( ) {
        $this->ExperienceModel->save( Control::getPostData( ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function deleteExperience( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );
        $vars['bool'] = 0;

        if( $this->ExperienceModel->deleteExperience( $post ) ) {
            $vars['bool'] = 1;
        }
        else {
            $vars['errMsg'] = $this->ExperienceModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Upload Attachment
     * @return void
     */
    public function uploadTestimonial( ) {
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
            if( $this->ExperienceModel->uploadSuccess( $file ) ) {
                $vars = $this->ExperienceModel->getFileInfo( );

                if( $vars['success'] == 2 ) {
                    unset( $vars['error'] );
                }
            }
            else {
                $vars['errMsg'] = $this->ExperienceModel->getErrMsg( );
            }
        }

        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return str
     */
    public function updateTestimonial( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );
        $vars['bool'] = 0;

        if( $this->ExperienceModel->updateTestimonial( $post ) ) {
            $vars['bool'] = 1;
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return str
     */
    public function deleteTestimonial( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );
        $vars['bool'] = 0;

        if( $this->ExperienceModel->deleteTestimonial( $post ) ) {
            $vars['bool'] = 1;
        }
        else {
            $vars['errMsg'] = $this->ExperienceModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }
}
?>