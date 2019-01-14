<?php
namespace Markaxis\Leave;
use \Library\IO\File;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: DesignationControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DesignationControl {


    // Properties


    /**
     * DesignationControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function saveType( ) {
        $post = Control::getPostData( );

        File::import( MODEL . 'Markaxis/Leave/DesignationModel.class.php' );
        $DesignationModel = DesignationModel::getInstance( );
        $DesignationModel->save( $post );
        Control::setPostData( $post );
    }
}
?>