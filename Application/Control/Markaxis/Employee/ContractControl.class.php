<?php
namespace Markaxis\Employee;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: ContractControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ContractControl {


    // Properties
    private $ContractModel;


    /**
     * ContractControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->ContractModel = ContractModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function settings( ) {
        $ContractView = new ContractView( );
        Control::setOutputArrayAppend( array( 'form' => $ContractView->renderSettings( ) ) );
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
    public function save( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );

        if( $this->ContractModel->isValid( $post ) ) {
            $post['userID'] = $this->ContractModel->save( );
            Control::setPostData( $post );
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->ContractModel->getErrMsg( );
            echo json_encode( $vars );
            exit;
        }
    }
}
?>