<?php
namespace Markaxis;
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
     * @return string
     */
    public function getMenu( $css ) {
        $AlumniModel = AlumniModel::getInstance( );

        $AlumniView = new AlumniView( $AlumniModel );
        return $AlumniView->renderMenu( $css );
    }
}
?>