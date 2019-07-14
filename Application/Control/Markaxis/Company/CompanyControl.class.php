<?php
namespace Markaxis\Company;
use \Markaxis\Employee\EmployeeView;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CompanyControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CompanyControl {


    // Properties
    private $CompanyView;


    /**
     * CompanyControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->CompanyView = new CompanyView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function setup( ) {
        $this->CompanyView->renderSetup( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function settings( ) {
        $output = Control::getOutputArray( );
        $this->CompanyView->renderSettings( $output );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getCountList( $data ) {
        $output = Control::getOutputArray( );

        if( isset( $output['list'] ) ) {
            $EmployeeView = new EmployeeView( );
            echo $EmployeeView->renderCountList( $output['list'] );
            exit;
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function edit( $args ) {
        $userID = isset( $args[1] ) ? (int)$args[1] : 0;

        $UserView = new UserView( );
        Control::setOutputArrayAppend( array( 'form' => $UserView->renderEdit( $userID ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function save( ) {
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );

        $UserModel = new UserModel( );

        if( $UserModel->isValid( $post ) ) {
            $post['userID'] = $UserModel->save( );

            $ChildrenModel = new ChildrenModel( );
            $ChildrenModel->save( $post );

            Control::setPostData( $post );
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $UserModel->getErrMsg( );
            echo json_encode( $vars );
            exit;
        }
    }
}
?>