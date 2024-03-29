<?php
namespace Markaxis\TaxFile;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TaxFileControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxFileControl {


    // Properties
    private $TaxFileModel;
    private $TaxFileView;


    /**
     * TaxControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->TaxFileModel = TaxFileModel::getInstance( );
        $this->TaxFileView = new TaxFileView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getTaxFileResults( ) {
        $post = Control::getRequest( )->request( POST );
        echo json_encode( $this->TaxFileModel->getResults( $post ) );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getDeclarationResults( ) {
        $post = Control::getRequest( )->request( POST );
        echo json_encode( $this->TaxFileModel->getDeclarationResults( $post ) );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function list( ) {
        $this->TaxFileView->renderTaxFile( );
    }


    /**
     * Render main navigation
     * @return void
     */
    public function employee( ) {
        $post = Control::getRequest( )->request( POST );
        echo json_encode( $this->TaxFileModel->getEmployeeResults( $post ) );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function taxFiling( $args ) {
        $this->TaxFileView->renderTaxFileForm( $args );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function showStatus( $args ) {
        if( isset( $args[1] ) ) {
            echo $this->TaxFileView->renderStatus( $args[1] );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return void
     */
    public function createForm( ) {
        $post = Control::getRequest( )->request( POST );
        $vars = array( );

        if( $vars['data'] = $this->TaxFileModel->createForm( $post ) ) {
            $vars['bool'] = 1;
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->TaxFileModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return void
     */
    public function prepareUserDeclaration( ) {
        sleep(.5);

        $vars = array( );
        $vars['bool'] = 1;
        $vars['data'] = Control::getOutputArray( );
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function editIr8a( $args ) {
        // tfID userID
        if( isset( $args[1] ) && isset( $args[2] ) ) {
            echo $this->TaxFileView->renderIr8aForm( $args[1], $args[2] );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function editA8a( $args ) {
        // tfID userID
        if( isset( $args[1] ) && isset( $args[2] ) ) {
            echo $this->TaxFileView->renderA8aForm( $args[1], $args[2] );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function authIRAS( ) {
        $vars = array( );
        $post = Control::getRequest( )->request( POST );

        if( isset( $post['tfID'] ) && $url = $this->TaxFileModel->authIRAS( $post['tfID'] ) ) {
            $vars['bool'] = 1;
            $vars['url'] = $url;
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->TaxFileModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function authCode( $args ) {
        // code & tfID & state
        if( isset( $args[1] ) && isset( $args[2] ) && isset( $args[3] ) ) {
            if( $token = $this->TaxFileModel->getAccessToken( $args[1], $args[2], $args[3] ) ) {
                $this->TaxFileModel->submitIRAS( $args[2], $args[3], $token );
                header( 'location: ' . ROOT_URL . 'admin/taxfile/list');
            }
        }
    }
}
?>