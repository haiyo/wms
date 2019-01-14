<?php
namespace Aurora\Component;
use \Library\IO\File;
use \Control;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: UploadControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UploadControl {


    // Properties


    /**
     * UploadControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function view( $args ) {
        File::import( MODEL . 'Aurora/Component/UploadModel.class.php' );
        $UploadModel = new UploadModel( );
        $UploadModel->view( $args );
    }
}
?>