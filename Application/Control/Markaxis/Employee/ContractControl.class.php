<?php
namespace Markaxis\Employee;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: ContractControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ContractControl extends Control {


    // Properties
    private $ContractModel;
    private $ContractView;


    /**
     * ContractControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->ContractModel = ContractModel::getInstance( );
        $this->ContractView = new ContractView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function settings( ) {
        if( Control::hasPermission( 'Markaxis', 'add_modify_contract' ) ) {
            Control::setOutputArrayAppend( $this->ContractView->renderSettings( ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getCountList( $data ) {
        if( isset( $data[1] ) && $data[1] == 'contract' && isset( $data[2] ) ) {
            Control::setOutputArrayAppend( array( 'list' => $this->ContractModel->getCountList( $data[2] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getContractResults( ) {
        $post = Control::getRequest( )->request( POST );

        echo json_encode( $this->ContractModel->getResults( $post ) );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getContract( $data ) {
        if( isset( $data[1] ) ) {
            $vars = array( );
            $vars['data'] = $this->ContractModel->getBycID( $data[1] );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveContract( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );

        if( $this->ContractModel->isValid( $post ) ) {
            $this->ContractModel->save( );
            $vars['bool'] = 1;
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->ContractModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deleteContract( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST ) );

        if( $vars['count'] = $this->ContractModel->delete( $post ) ) {
            $vars['bool'] = 1;
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->ContractModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }
}
?>