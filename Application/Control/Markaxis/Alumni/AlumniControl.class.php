<?php
namespace Markaxis;
use \Library\IO\File;
use \Control;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: AlumniControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AlumniControl {


    // Properties


    /**
     * AlumniControl Constructor
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
        File::import( MODEL . 'Markaxis/Alumni/AlumniModel.class.php' );
        $AlumniModel = AlumniModel::getInstance( );

        File::import( VIEW . 'Markaxis/Alumni/AlumniView.class.php' );
        $AlumniView = new AlumniView( $AlumniModel );
        return $AlumniView->renderMenu( $css );
    }
}
?>