<?php
namespace Markaxis\Expense;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: ManagerControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ManagerControl {


    // Properties
    private $ManagerModel;


    /**
     * ManagerControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->ManagerModel = ManagerModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getClaimResults( ) {
        $data = Control::getOutputArray( );
        echo json_encode( $this->ManagerModel->getResults( $data['list'] ) );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getClaim( $data ) {
        $data = Control::getOutputArray( );
        $data['data']['managers'] = $this->ManagerModel->getByEcID( $data['data']['ecID'] );

        $vars = array( );
        $vars['data'] = $data['data'];
        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getRequest( ) {
        $data = Control::getOutputArray( );

        if( isset( $data['claim'] ) ) {
            $data['claim'] = $this->ManagerModel->getRequest( $data['claim'] );

            $ClaimView = new ClaimView( );
            Control::setOutputArrayAppend( array( 'request' => $ClaimView->renderRequest( $data['claim'] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function setClaimAction( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST ) );

        if( $this->ManagerModel->setClaimAction( $post ) ) {
            $vars['bool'] = 1;
        }
        else {
            $vars['bool'] = 0;
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveClaim( ) {
        $post = Control::getPostData( );

        if( $post['ecID'] ) {
            $this->ManagerModel->save( $post );

            $vars['bool'] = 1;
            $vars['data'] = $post;
            echo json_encode( $vars );
            exit;
        }
    }
}
?>