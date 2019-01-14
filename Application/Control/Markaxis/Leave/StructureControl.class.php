<?php
namespace Markaxis\Leave;
use \Library\IO\File;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: StructureControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class StructureControl {


    // Properties


    /**
     * StructureControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function addType( ) {
        File::import( VIEW . 'Markaxis/Leave/StructureView.class.php' );
        $StructureView = new StructureView( );
        Control::setOutputArrayAppend( array( 'form' => $StructureView->renderAddType( ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function editType( $args ) {
        $ltID = isset( $args[1] ) ? (int)$args[1] : 0;

        File::import( VIEW . 'Markaxis/Leave/StructureView.class.php' );
        $StructureView = new StructureView( );
        Control::setOutputArrayAppend( array( 'form' => $StructureView->renderEditType( $ltID ) ) );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function saveType( ) {
        $post = Control::getPostData( );

        File::import( MODEL . 'Markaxis/Leave/StructureModel.class.php' );
        $StructureModel = StructureModel::getInstance( );
        $StructureModel->save( $post );
        Control::setPostData( $post );
    }
}
?>