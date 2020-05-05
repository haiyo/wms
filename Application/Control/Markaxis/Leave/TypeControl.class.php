<?php
namespace Markaxis\Leave;
use \Markaxis\Employee\EmployeeModel;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TypeControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TypeControl {


    // Properties
    private $TypeModel;
    private $TypeView;


    /**
     * TypeControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->TypeModel = TypeModel::getInstance( );
        $this->TypeView = new TypeView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function globalInit( ) {
        $data = Control::getOutputArray( );

        if( isset( $data['ltIDs'] ) && is_array( $data['ltIDs'] ) && sizeof( $data['ltIDs'] ) > 0 ) {
            Control::setOutputArrayAppend( array( 'leaveTypes' => $this->TypeModel->getByIDs( $data['ltIDs'] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function settings( ) {
        $output = Control::getOutputArray( );
        Control::setOutputArrayAppend( array( 'form' => $this->TypeView->renderSettings( ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getTypeResults( ) {
        $post = Control::getRequest( )->request( POST );
        echo json_encode( $this->TypeModel->getResults( $post ) );
        exit;
    }


    /**
     * Render main navigation
     * @return string
     */
    public function addType( ) {
        $output = Control::getOutputArray( );

        Control::setOutputArrayAppend( array( 'form' => $this->TypeView->renderAddType( ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function editType( $args ) {
        $ltID = isset( $args[1] ) ? (int)$args[1] : 0;

        Control::setOutputArrayAppend( array( 'form' => $this->TypeView->renderEditType( $ltID ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveType( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );

        if( $post['ltID'] = $this->TypeModel->save( $post ) ) {
            $post['bool'] = 1;
            Control::setPostData( $post );
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $this->TypeModel->getErrMsg( );
            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveEmployee( ) {
        $FinanceModel = FinanceModel::getInstance( );
        $FinanceModel->save( Control::getPostData( ) );
    }
}
?>