<?php
namespace Markaxis;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: AttendanceControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AttendanceControl {


    // Properties


    /**
     * AttendanceControl Constructor
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
        $AttendanceModel = AttendanceModel::getInstance( );
        $AttendanceView = new AttendanceView( $AttendanceModel );
        return $AttendanceView->renderMenu( $css );
    }
}
?>