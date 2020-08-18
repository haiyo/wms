<?php
namespace Markaxis\Expense;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: ClaimControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ClaimControl {


    // Properties
    protected $ClaimModel;
    protected $ClaimView;


    /**
     * ClaimControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->ClaimModel = ClaimModel::getInstance( );
        $this->ClaimView = new ClaimView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function dashboard( ) {
        Control::setOutputArrayAppend( array( 'js' => array( 'markaxis' => array( 'claim.js' ) ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getChart( ) {
        $vars = array( );
        $post = Control::getRequest( )->request( POST );

        if( isset( $post['date'] ) ) {
            $vars['bool'] = 1;
            Control::setOutputArrayAppend( array( 'data' => $this->ClaimModel->getChart( $post['date'] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function claim( ) {
        $this->ClaimView->renderClaimList( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getPendingAction( ) {
        Control::setOutputArrayAppend( array( 'pending' => $this->ClaimView->renderPendingAction( ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getRequest( ) {
        if( $request = $this->ClaimModel->getRequest( ) ) {
            Control::setOutputArrayAppend( array( 'claim' => $request ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getClaim( $data ) {
        if( isset( $data[1] ) ) {
            Control::setOutputArray( array( 'data' => $this->ClaimModel->getByEcID( $data[1] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getClaimResults( ) {
        $post = Control::getRequest( )->request( POST );
        Control::setOutputArray( array( 'list' => $this->ClaimModel->getResults( $post ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( $this->ClaimModel->processPayroll( $data ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function reprocessPayroll( ) {
        $this->processPayroll( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function savePayroll( ) {
        $data = Control::getOutputArray( );
        $post = Control::getRequest( )->request( POST );
        Control::setOutputArray( $this->ClaimModel->savePayroll( $data, $post ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deletePayroll( ) {
        $data = Control::getOutputArray( );
        $this->ClaimModel->deletePayroll( $data );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveClaim( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );

        if( $this->ClaimModel->isValid( $post ) ) {
            $this->ClaimModel->save( );
            Control::setPostData( array_merge( $post, $this->ClaimModel->getInfo( ) ) );
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->ClaimModel->getErrMsg( );
            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function cancelClaim( ) {
        $ecID = Control::getRequest( )->request( POST, 'data' );

        $this->ClaimModel->cancel( $ecID );
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
        $ecID = Control::getRequest( )->request( POST, 'ecID' );
        $file = Control::getRequest( )->request( FILES );

        if( $_SERVER['REQUEST_METHOD'] == 'POST' && empty( $_POST ) && empty( $_FILES ) &&
            $_SERVER['CONTENT_LENGTH'] > 0 ) {
            $vars['error'] = 'No files uploaded. Please make sure file size is within the allowed limit.';
        }
        else {
            if( $this->ClaimModel->uploadSuccess( $ecID, $file ) ) {
                $vars = $this->ClaimModel->getFileInfo( );

                if( $vars['success'] == 2 ) {
                    unset( $vars['error'] );
                }
            }
            else {
                $vars['errMsg'] = $this->ClaimModel->getErrMsg( );
            }
        }
        echo json_encode( $vars );
        exit;
    }
}
?>