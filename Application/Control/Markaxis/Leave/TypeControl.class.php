<?php
namespace Markaxis\Leave;
use \Library\IO\File;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: TypeControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TypeControl {


    // Properties


    /**
     * TypeControl Constructor
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
        $output = Control::getOutputArray( );

        File::import( VIEW . 'Markaxis/Leave/TypeView.class.php' );
        $TypeView  = new TypeView( );
        Control::setOutputArrayAppend( array( 'form' => $TypeView->renderSettings( ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function addType( ) {
        $output = Control::getOutputArray( );

        File::import( VIEW . 'Markaxis/Leave/TypeView.class.php' );
        $TypeView  = new TypeView( );
        Control::setOutputArrayAppend( array( 'form' => $TypeView->renderAddType( ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function editType( $args ) {
        $ltID = isset( $args[1] ) ? (int)$args[1] : 0;

        File::import( VIEW . 'Markaxis/Leave/TypeView.class.php' );
        $TypeView  = new TypeView( );
        Control::setOutputArrayAppend( array( 'form' => $TypeView->renderEditType( $ltID ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function saveType( ) {;
        $post = Control::getDecodedArray( Control::getRequest( )->request( POST, 'data' ) );

        File::import( MODEL . 'Markaxis/Leave/TypeModel.class.php' );
        $TypeModel = TypeModel::getInstance( );

        if( $post['ltID'] = $TypeModel->save( $post ) ) {
            $post['bool'] = 1;
            Control::setPostData( $post );
        }
        else {
            $vars['bool'] = 0;
            $vars['errMsg'] = $TypeModel->getErrMsg( );
            echo json_encode( $vars );
            exit;
        }
    }
}
?>