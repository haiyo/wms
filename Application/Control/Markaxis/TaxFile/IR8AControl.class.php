<?php
namespace Markaxis\TaxFile;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: IR8AControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class IR8AControl {


    // Properties
    private $IR8AModel;
    private $IR8AView;


    /**
     * IR8AControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->IR8AModel = IR8AModel::getInstance( );
        $this->IR8AView = new IR8AView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getDeclarationResults( ) {
        $post = Control::getRequest( )->request( POST );
        $this->IR8AModel->createDeclaration( $post );
    }


    /**
     * Render main navigation
     * @return void
     */
    public function prepareUserDeclaration( ) {
        $data = Control::getOutputArray( );
        $post = Control::getRequest( )->request( POST );

        Control::setOutputArray( array( 'ir8a' => $this->IR8AModel->prepareUserDeclaration( $data, $post ) ) );
    }


    /**
     * Render main navigation
     * @return void
     */
    public function saveIr8a( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST ) );
        $vars = array( );

        if( $vars['data'] = $this->IR8AModel->saveIr8a( $post ) ) {
            $vars['bool'] = 1;
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->IR8AModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function downloadIR8A( $args ) {
        // tfID
        if( isset( $args[1] ) ) {
            echo $this->IR8AView->renderXML( $args[1] );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function viewIr8a( $args ) {
        //userID && year
        if( Control::hasPermission('Markaxis', 'process_payroll' ) &&
            isset( $args[1] ) && isset( $args[2] ) ) {
            $this->IR8AView->renderIr8a( $args[1], $args[2] );
            exit;
        }
    }
}
?>