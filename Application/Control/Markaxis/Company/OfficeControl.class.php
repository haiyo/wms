<?php
namespace Markaxis\Company;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: OfficeControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class OfficeControl {


    // Properties
    private $OfficeModel;


    /**
     * OfficeControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->OfficeModel = OfficeModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function settings( ) {
        $OfficeView = new OfficeView( );
        Control::setOutputArrayAppend( $OfficeView->renderSettings( ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getOfficeResults( ) {
        $post = Control::getRequest( )->request( POST );
        echo json_encode( $this->OfficeModel->getResults( $post ) );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getOffice( $data ) {
        if( isset( $data[1] ) ) {
            $vars = array( );
            $vars['data'] = $this->OfficeModel->getByoID( $data[1] );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveOffice( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );

        if( $this->OfficeModel->isValid( $post ) ) {
            $this->OfficeModel->save( );
            $vars['bool'] = 1;
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->OfficeModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deleteOffice( ) {
        $oID = Control::getRequest( )->request( POST, 'data' );

        $this->OfficeModel->delete( $oID );
        $vars['bool'] = 1;
        echo json_encode( $vars );
        exit;
    }
}
?>