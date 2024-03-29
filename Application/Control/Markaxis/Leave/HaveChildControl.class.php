<?php
namespace Markaxis\Leave;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: HaveChildControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class HaveChildControl {


    // Properties


    /**
     * HaveChildControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return string
     */
    public function saveType( ) {
        $post = Control::getPostData( );

        $HaveChildModel = HaveChildModel::getInstance( );
        $HaveChildModel->save( $post );
        Control::setPostData( $post );
    }
}
?>