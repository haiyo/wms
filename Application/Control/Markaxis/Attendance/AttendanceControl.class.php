<?php
namespace Markaxis;
use \Library\IO\File;
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
     * @return str
     */
    public function getMenu( $css ) {
        File::import( MODEL . 'Markaxis/Attendance/AttendanceModel.class.php' );
        $AttendanceModel = AttendanceModel::getInstance( );

        File::import( VIEW . 'Markaxis/Attendance/AttendanceView.class.php' );
        $AttendanceView = new AttendanceView( $AttendanceModel );
        return $AttendanceView->renderMenu( $css );
    }
}
?>