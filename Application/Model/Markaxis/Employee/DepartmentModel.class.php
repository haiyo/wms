<?php
namespace Markaxis\Employee;
use \Aurora\Component\DepartmentModel AS A_DepartmentModel;

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
    public function isFoundByUserID( $userID, $dID ) {
        return $this->Department->isFoundByUserID( $userID, $dID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByUserID( $userID ) {
        return $this->Department->getByUserID( $userID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getListByUserID( $userID ) {
        return $this->info = $this->Department->getListByUserID( $userID );
    }


    /**
     * Save Employee Competencies
     * @return void
     */
    public function save( $data ) {
        if( isset( $data['department'] ) && is_array( $data['department'] ) ) {
            $A_DepartmentModel = A_DepartmentModel::getInstance( );
            $validdID = array( );

            foreach( $data['department'] as $dID ) {
                if( $A_DepartmentModel->isFoundByID( $dID ) ) {
                    if( !$this->isFoundByUserID( $data['userID'], $dID ) ) {
                        $info = array( );
                        $info['userID'] = (int)$data['userID'];
                        $info['departmentID'] = (int)$dID;
                        $this->Department->insert( 'employee_department', $info );
                    }
                }
                array_push( $validdID, $dID );
            }
            $department = implode( ',', $validdID );

            if( $department )
                $this->Department->delete( 'employee_department', 'WHERE userID = "' . (int)$data['userID'] . '" AND 
                                            departmentID NOT IN(' . addslashes( $department ) . ')' );
        }
    }


    /**
     * Set Pay Item Info
     * @return bool
     */
    public function saveDepartment( $data ) {
        if( isset( $data['dID'] ) ) {
            $ManagerModel = ManagerModel::getInstance( );
            $managers = $ManagerModel->getValidManagerID( );
            $success = array( );

            if( sizeof( $managers ) > 0 ) {
                foreach( $managers as $managerID ) {
                    if( !$this->isFoundByUserID( $managerID, $data['dID'] ) ) {
                        // Add manager who are not already in this department
                        $info = array( );
                        $info['userID'] = (int)$managerID;
                        $info['departmentID'] = (int)$data['dID'];
                        $this->Department->insert( 'employee_department', $info );
                    }
                    array_push( $success, $managerID );
                }
            }
        }
    }
}
?>