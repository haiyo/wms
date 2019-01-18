<?php
namespace Markaxis\PostJob;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: PostJobControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PostJobControl {


    // Properties
    protected $PostJobModel;
    protected $PostJobView;


    /**
     * PostJobControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->PostJobModel = PostJobModel::getInstance( );
        $this->PostJobView = new PostJobView( $this->PostJobModel );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getMenu( $css ) {
        return $this->PostJobView->renderMenu( $css );
    }


    /**
     * Render main navigation
     * @return str
     */
    public function getInternalJobMenu( $css ) {
        return $this->PostJobView->renderInternalJobMenu( $css );
    }
}
?>