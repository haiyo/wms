<?php
namespace Markaxis\Leave;
use \Library\IO\File;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: GenderControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class GenderControl {


    // Properties


    /**
     * GenderControl Constructor
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

        File::import( MODEL . 'Markaxis/Leave/GenderModel.class.php' );
        $GenderModel = GenderModel::getInstance( );
        $GenderModel->save( $post );
        Control::setPostData( $post );
    }
}
?>