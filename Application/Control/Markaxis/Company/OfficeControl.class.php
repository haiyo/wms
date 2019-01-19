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


    /**
     * OfficeControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function settings( ) {
        $OfficeView = new OfficeView( );
        Control::setOutputArrayAppend( array( 'form' => $OfficeView->renderSettings( ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getOfficeResults( ) {
        $post = Control::getRequest( )->request( POST );

        $OfficeModel = OfficeModel::getInstance( );
        echo json_encode( $OfficeModel->getResults( $post ) );
        exit;
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