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
        if( Control::hasPermission('Markaxis', 'add_modify_employee' ) ) {
            $output = Control::getOutputArray( );
            $this->EmployeeView->renderSettings( $output );
        }
    }


    /**
     * Render main navigation
     * @return void
     */
    public function getList( $args ) {
        if( isset( $args[1] ) ) {
            $includeOwn = isset( $args[2] );
            echo json_encode( $this->EmployeeModel->getList( $args[1], 0, 0, $includeOwn ) );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return void
     */
    public function getCountList( ) {
        if( Control::hasPermission('Markaxis','add_modify_employee' ) ) {
            $output = Control::getOutputArray( );

            if( isset( $output['list'] ) ) {
                echo $this->EmployeeView->renderCountList( $output['list'] );
                exit;
            }
        }
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function prepareUserDeclaration( ) {
        $post = Control::getRequest( )->request( POST );

        if( isset( $post['userID'] ) ) {
            Control::setOutputArrayAppend( array( 'empIR8AInfo' => $this->EmployeeModel->getIR8AInfo( $post['userID'] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return void
     */
    public function list( ) {
        if( Control::hasPermission('Markaxis', 'view_employee_listing' ) ) {
            $this->EmployeeView->renderUserList( );
        }
    }


    /**
     * Render main navigation
     * @return void
     */
    public function results( ) {
        if( Control::hasPermission('Markaxis', 'view_employee_listing' ) ) {
            $post = Control::getRequest( )->request( POST );
            echo json_encode( $this->EmployeeModel->getResults( $post ) );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return void
     */
    public function search( ) {
        if( Control::hasPermission('Markaxis', 'view_employee_listing' ) ) {
            $post = Control::getRequest( )->request( POST );

            $vars = array( );
            $vars['bool'] = 1;
            $vars['html'] = $this->EmployeeView->renderUserCard( $post['q'], $post['department'], $post['designation'] );

            echo json_encode( $vars );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return void
     */
    public function add( ) {
        if( Control::hasPermission('Markaxis', 'add_modify_employee' ) ) {
            Control::setOutputArrayAppend( array( 'form' => $this->EmployeeView->renderAdd( ) ) );
        }
    }


    /**
     * Render main navigation
     * @return void
     */
    public function edit( $args ) {
        if( Control::hasPermission('Markaxis', 'add_modify_employee' ) ) {
            $userID = isset( $args[1] ) ? (int)$args[1] : 0;
            Control::setOutputArrayAppend( array( 'form' => $this->EmployeeView->renderEdit( $userID ) ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function processPayroll( $args, $recalculate=false ) {
        try {
            if( Control::hasPermission('Markaxis', 'process_payroll' ) &&
                isset( $args[1] ) && $empInfo = $this->EmployeeModel->getProcessInfo( $args[1] ) ) {

                Control::setOutputArray( array( 'empInfo' => $empInfo ) );

                if( !$recalculate ) {
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
    public function recalculate( $args ) {
        $this->processPayroll( $args,true );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function viewSaved( $args ) {
        $this->processPayroll( $args );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function viewSlip( $args ) {
        $this->processPayroll( $args );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function savePayroll( ) {
        try {
            $post = Control::getRequest( )->request( POST, 'data' );

            if( isset( $post['userID'] ) ) {
                $this->processPayroll( array( 1 => $post['userID'] ),true );
            }
            else {
                throw( new PageNotFoundException( HttpResponse::HTTP_NOT_FOUND ) );
            }
        }
        catch( PageNotFoundException $e ) {
            $e->record( );
            HttpResponse::sendHeader( HttpResponse::HTTP_NOT_FOUND );
            header( 'location: ' . ROOT_URL . 'admin/notfound' );
            exit;
        }
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
        if( Control::hasPermission('Markaxis', 'add_modify_employee' ) ) {
            $post = Control::getPostData( );
            $post['eID'] = $this->EmployeeModel->save( $post );
            Control::setPostData( $post );
        }
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
        if( Control::hasPermission('Markaxis', 'add_modify_employee' ) ) {
            $post = Control::getRequest( )->request( POST );
            $this->EmployeeModel->setResignStatus( $post );

            $vars = array( );
            $vars['bool'] = 1;
            echo json_encode( $vars );
            exit;
        }
    }
}
?>