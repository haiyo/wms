<?php
namespace Markaxis\Leave;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: DesignationControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DesignationControl {


    // Properties
    protected $DesignationModel;


    /**
     * DesignationControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->DesignationModel = DesignationModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getGroup( ) {
        $data = Control::getOutputArray( );

        if( isset( $data['group'] ) ) {
            Control::setOutputArray( array( 'designations' => $this->DesignationModel->getBylgID( $data['group']['lgID'] ) ) );
        }
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveType( ) {
        $post = Control::getPostData( );

        $this->DesignationModel->save( $post );
        Control::setPostData( $post );
    }
}
?>