<?php
namespace Markaxis\Leave;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: StructureControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class StructureControl {


    // Properties
    protected $StructureModel;
    protected $StructureView;


    /**
     * StructureControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->StructureModel = StructureModel::getInstance( );
        $this->StructureView = new StructureView( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function addType( ) {
        Control::setOutputArrayAppend( array( 'form' => $this->StructureView->renderAddType( ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function editType( $args ) {
        $ltID = isset( $args[1] ) ? (int)$args[1] : 0;

        Control::setOutputArrayAppend( array( 'form' => $this->StructureView->renderEditType( $ltID ) ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveType( ) {
        $post = Control::getPostData( );

        $this->StructureModel->save( $post );
        Control::setPostData( $post );
    }
}
?>