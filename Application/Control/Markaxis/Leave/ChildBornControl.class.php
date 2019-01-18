<?php
namespace Markaxis\Leave;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: ChildBornControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ChildBornControl {


    // Properties


    /**
     * ChildBornControl Constructor
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

        $ChildBornModel = ChildBornModel::getInstance( );
        $ChildBornModel->save( $post );
        Control::setPostData( $post );
    }
}
?>