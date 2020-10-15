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
    private $OfficeView;


    /**
     * OfficeControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->OfficeModel = OfficeModel::getInstance( );
        $this->OfficeView = new OfficeView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function settings( ) {
        if( Control::hasPermission( 'Markaxis', 'add_modify_office' ) ) {
            Control::setOutputArrayAppend( $this->OfficeView->renderSettings( ) );
        }
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
    public function getOffice( $args ) {
        if( isset( $args[1] ) && is_numeric( $args[1] ) ) {
            $vars = array( );
            $vars['data'] = $this->OfficeModel->getByoID( $args[1] );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( ) {
        $data = Control::getOutputArray( );
        Control::setOutputArray( array( 'office' => $this->OfficeModel->getWorkDaysOfMonth( $data ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function recalculate( ) {
        $this->processPayroll( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function viewSaved( ) {
        $this->processPayroll( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function viewSlip( ) {
        $this->processPayroll( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function savePayroll( ) {
        $this->processPayroll( );
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

        if( $this->OfficeModel->delete( $oID ) ) {
            $vars['bool'] = 1;
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->OfficeModel->getErrMsg( );
        }
        echo json_encode( $vars );
        exit;
    }
}
?>