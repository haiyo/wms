<?php
namespace Markaxis\Employee;
use \Control;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 10th, 2012
 * @version $Id: LeaveTypeControl.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveTypeControl {


    // Properties
    protected $LeaveTypeModel;


    /**
     * LeaveTypeControl Constructor
     * @return void
     */
    function __construct( ) {
        $this->LeaveTypeModel = LeaveTypeModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function globalInit( ) {
        $EmployeeModel = EmployeeModel::getInstance( );
        $empInfo = $EmployeeModel->getInfo( );

        if( sizeof( $empInfo ) > 0 ) {
            $ltInfo = array_column( $this->LeaveTypeModel->getByUserID( $empInfo['userID'], 'ltID' ), 'ltID' );
            Control::setOutputArrayAppend( array( 'ltIDs' => $ltInfo ) );
        }
    }
}
?>