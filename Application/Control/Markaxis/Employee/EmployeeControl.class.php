<?php
namespace Markaxis\Employee;
use \Control;
use \Library\Http\HttpResponse;
use \Library\Exception\Aurora\PageNotFoundException;

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
            echo json_encode( $this->EmployeeModel->getList( $args[1], 0, 0, $includeOwn ) );
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
        $this->EmployeeView->renderUserList( );
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
    public function search( ) {
        $post = Control::getRequest( )->request( POST );

        $vars = array( );
        $vars['bool'] = 1;
        $vars['html'] = $this->EmployeeView->renderUserCard( $post['q'], $post['department'], $post['designation'] );

        echo json_encode( $vars );
        exit;
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
     * @return string
     */
    public function processPayroll( $args, $reprocess=false ) {
        try {
            if( isset( $args[1] ) && $empInfo = $this->EmployeeModel->getProcessInfo( $args[1] ) ) {
                Control::setOutputArray( array( 'empInfo' => $empInfo ) );

                if( !$reprocess ) {
                    Control::setOutputArray( $this->EmployeeView->renderProcessForm( $empInfo ) );
                }
            }
            else {
                throw( new PageNotFoundException( HttpResponse::HTTP_NOT_FOUND ) );
            }
        }
        catch( PageNotFoundException $e ) {
            $e->record( );
            HttpResponse::sendHeader( HttpResponse::HTTP_NOT_FOUND );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function reprocessPayroll( $args ) {
        $this->processPayroll( $args,true );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function savePayroll( $args ) {
        $this->processPayroll( $args,true );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function deletePayroll( $args ) {
        $this->processPayroll( $args,true );
    }


    /**
     * Render main navigation
     * @return void
     */
    public function saveUser( ) {
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
    public function setResignStatus( ) {
        $post = Control::getRequest( )->request( POST );

        $vars = array( );
        $vars['bool'] = $this->EmployeeModel->setResignStatus( $post );

        echo json_encode( $vars );
        exit;
    }
}
?>