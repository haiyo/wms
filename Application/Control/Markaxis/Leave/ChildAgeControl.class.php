<?php
namespace Markaxis\Leave;
use \Library\IO\File;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: ChildAgeControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ChildAgeControl {


    // Properties


    /**
     * ChildAgeControl Constructor
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

        File::import( MODEL . 'Markaxis/Leave/ChildAgeModel.class.php' );
        $ChildAgeModel = ChildAgeModel::getInstance( );
        $ChildAgeModel->save( $post );
        Control::setPostData( $post );
    }
}
?>