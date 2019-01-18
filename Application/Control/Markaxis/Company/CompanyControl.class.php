<?php
namespace Markaxis\Company;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: CompanyControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CompanyControl {


    // Properties


    /**
     * CompanyControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function setup( ) {
        $CompanyView = new CompanyView( );
        //Control::setOutputArrayAppend( array( 'form' => $CompanyView->renderSetup( ) ) );
        $CompanyView->printAll( $CompanyView->renderSetup( ), true );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function settings( ) {
        $output = Control::getOutputArray( );
        $form = isset( $output['form'] ) ? $output['form'] : '';

        $CompanyView = new CompanyView( );
        $CompanyView->printAll( $CompanyView->renderSettings( $form ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function edit( $args ) {
        $userID = isset( $args[1] ) ? (int)$args[1] : 0;

        $UserView = new UserView( );
        Control::setOutputArrayAppend( array( 'form' => $UserView->renderEdit( $userID ) ) );
    }


    /**
     * Render main navigation
     * @return str
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