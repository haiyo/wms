<?php
namespace Markaxis\Employee;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: EmployeeControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EmployeeControl {


    // Properties
    protected $EmployeeModel;
    protected $EmployeeView;


    /**
     * EmployeeControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->EmployeeModel = EmployeeModel::getInstance( );
        $this->EmployeeView = new EmployeeView( );
    }


    /**
     * Render main navigation
     * @return void
     */
    public function settings( ) {
        $output = Control::getOutputArray( );
        $this->EmployeeView->renderSettings( $output );
    }


    /**
     * Render main navigation
     * @return void
     */
    public function getList( $args ) {
        if( isset( $args[1] ) ) {
            $includeOwn = isset( $args[2] ) ? true : false;
            echo json_encode( $this->EmployeeModel->getList( $args[1], $includeOwn ) );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return void
     */
    public function getCountList( $data ) {
        $output = Control::getOutputArray( );

        if( isset( $output['list'] ) ) {
            echo $this->EmployeeView->renderCountList( $output['list'] );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return void
     */
    public function list( ) {
        $this->EmployeeView->renderList( );
    }


    /**
     * Render main navigation
     * @return void
     */
    public function view( ) {
        echo $this->EmployeeView->renderEdit( );
    }


    /**
     * Render main navigation
     * @return void
     */
    public function add( ) {
        Control::setOutputArrayAppend( array( 'form' => $this->EmployeeView->renderAdd( ) ) );
    }


    /**
     * Render main navigation
     * @return void
     */
    public function edit( $args ) {
        $userID = isset( $args[1] ) ? (int)$args[1] : 0;
        Control::setOutputArrayAppend( array( 'form' => $this->EmployeeView->renderEdit( $userID ) ) );
    }


    /**
     * Render main navigation
     * @return void
     */
    public function save( ) {
        $post = Control::getPostData( );
        $post['eID'] = $this->EmployeeModel->save( $post );
        Control::setPostData( $post );
    }


    /**
     * Render main navigation
     * @return void
     */
    public function log( $args ) {
        $userID = isset( $args[1] ) ? (int)$args[1] : 0;
        echo $this->EmployeeView->renderLog( $userID );
    }


    /**
     * Render main navigation
     * @return void
     */
    public function logResults( $args ) {
        $userID = isset( $args[1] ) ? (int)$args[1] : 0;
        $post = Control::getRequest( )->request( POST );

        echo json_encode( $this->EmployeeModel->getLogsByUserID( $post, $userID ) );
        exit;
    }


    /**
     * Render main navigation
     * @return void
     */
    public function results( ) {
        $post = Control::getRequest( )->request( POST );
        echo json_encode( $this->EmployeeModel->getResults( $post ) );
        exit;
    }


    /**
     * Render main navigation
     * @return void
     */
    public function setResignStatus( ) {
        $post = Control::getRequest( )->request( POST );

        $vars = array( );
        $vars['bool'] = $this->EmployeeModel->setResignStatus( $post );

        echo json_encode( $vars );
        exit;
    }
}
?>