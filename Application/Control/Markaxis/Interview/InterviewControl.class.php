<?php
namespace Markaxis\Interview;
use \Library\IO\File;
use \Control;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: InterviewControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class InterviewControl {


    // Properties


    /**
     * InterviewControl Constructor
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
        File::import( MODEL . 'Markaxis/Interview/InterviewModel.class.php' );
        $InterviewModel = InterviewModel::getInstance( );

        File::import( VIEW . 'Markaxis/Interview/InterviewView.class.php' );
        $InterviewView = new InterviewView( $InterviewModel );
        return $InterviewView->renderMenu( $css );
    }
}
?>