<?php
namespace Markaxis\Employee;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: DepartmentModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DepartmentModel extends \Model {


    // Properties
    protected $Department;



    /**
     * DepartmentModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->Department = new Department( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID ) {
        return $this->Department->isFoundByUserID( $userID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByUserID( $userID, $column ) {
        return $this->Department->getByUserID( $userID, $column );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getListByUserID( $userID ) {
        return $this->info = $this->Department->getListByUserID( $userID );
    }


    /**
     * Return total count of records
     * @return int

    public function existByLTIDs( $ltIDs ) {
        return (int)$this->LeaveType->existByLTIDs( $ltIDs );
    } */


    /**
     * Return a list of all users
     * @return mixed
     */
    public function save( $data ) {
        if( isset( $data['department'] ) && is_array( $data['department'] ) ) {
            // Make sure all department IDs are valid
            if( $this->existByLTIDs( $data['ltID'] ) ) {
                $this->LeaveType->delete('employee_department', 'WHERE userID = "' . (int)$data['userID'] . '"');

                $saveInfo = array( );
                $saveInfo['userID'] = (int)$data['userID'];

                foreach( $data['ltID'] as $value ) {
                    $saveInfo['ltID'] = (int)$value;
                    $this->LeaveType->insert( 'employee_department', $saveInfo );
                }
            }
        }
        // If no tgID is pass in, delete any existing data
        else {
            $this->LeaveType->delete('employee_department', 'WHERE userID = "' . (int)$data['userID'] . '"');
        }
    }
}
?>