<?php
namespace Markaxis\Employee;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: LeaveTypeModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveTypeModel extends \Model {


    // Properties
    protected $LeaveType;



    /**
     * LeaveTypeModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->info['pcID'] = '';

        File::import(DAO . 'Markaxis/Employee/LeaveType.class.php');
        $this->LeaveType = new LeaveType( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID ) {
        return $this->LeaveType->isFoundByUserID( $userID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByUserID( $userID, $column ) {
        return $this->LeaveType->getByUserID( $userID, $column );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getListByUserID( $userID ) {
        return $this->info = $this->LeaveType->getListByUserID( $userID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function existByLTIDs( $ltIDs ) {
        return (int)$this->LeaveType->existByLTIDs( $ltIDs );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function save( $data ) {
        if( isset( $data['ltID'] ) && is_array( $data['ltID'] ) ) {
            // Make sure all ltIDs are valid
            if( $this->existByLTIDs( $data['ltID'] ) ) {
                $this->LeaveType->delete('employee_leave_type', 'WHERE userID = "' . (int)$data['userID'] . '"');

                $saveInfo = array( );
                $saveInfo['userID'] = (int)$data['userID'];

                foreach( $data['ltID'] as $value ) {
                    $saveInfo['ltID'] = (int)$value;
                    $this->LeaveType->insert( 'employee_leave_type', $saveInfo );
                }
            }
        }
        // If no tgID is pass in, delete any existing data
        else if( $this->Tax->isFoundByUserID( $data['userID'] ) ) {
            $this->LeaveType->delete('employee_leave_type', 'WHERE userID = "' . (int)$data['userID'] . '"');
        }
    }
}
?>