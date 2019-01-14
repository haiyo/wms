<?php
namespace Markaxis\PostJob;
use \Library\IO\File;
use \Control;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: PostJobControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PostJobControl {


    // Properties


    /**
     * PostJobControl Constructor
     * @return void
     */
    function __construct( ) {
        //
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getMenu( $css ) {
        File::import( MODEL . 'Markaxis/Interview/PostJobModel.class.php' );
        $PostJobModel = PostJobModel::getInstance( );

        File::import( VIEW . 'Markaxis/Interview/PostJobView.class.php' );
        $PostJobView = new PostJobView( $PostJobModel );
        return $PostJobView->renderMenu( $css );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getInternalJobMenu( $css ) {
        File::import( MODEL . 'Markaxis/Interview/PostJobModel.class.php' );
        $PostJobModel = PostJobModel::getInstance( );

        File::import( VIEW . 'Markaxis/Interview/PostJobView.class.php' );
        $PostJobView = new PostJobView( $PostJobModel );
        return $PostJobView->renderInternalJobMenu( $css );
    }
}
?>