<?php
namespace Markaxis\Employee;
use \Library\IO\File;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: DepartmentModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DepartmentModel extends \Model {


    // Properties


    /**
     * DepartmentModel Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $edID ) {
        File::import(DAO . 'Markaxis/Employee/Department.class.php');
        $Department = new Department();
        return $Department->isFound( $edID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID, $dID ) {
        File::import(DAO . 'Markaxis/Employee/Department.class.php');
        $Department = new Department();
        return $Department->isFoundByUserID( $userID, $dID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getByUserID( $userID ) {
        File::import(DAO . 'Markaxis/Employee/Department.class.php');
        $Department = new Department();
        return $Department->getByUserID( $userID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        File::import(DAO . 'Markaxis/Employee/Department.class.php');
        $Department = new Department();
        return $Department->getList( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function save( $data ) {
        if( isset( $data['department'] ) && is_array( $data['department'] ) && isset( $data['userID'] ) && $data['userID'] ) {
            File::import( DAO . 'Aurora/Component/Department.class.php' );
            $DepartmentComponent = new \Aurora\Department( );

            File::import( DAO . 'Markaxis/Employee/Department.class.php' );
            $Department = new Department( );

            foreach( $data['department'] as $value ) {
                if( $DepartmentComponent->isFound( $value ) && !$this->isFoundByUserID( $data['userID'], $value ) ) {
                    $info = array( );
                    $info['userID'] = (int)$data['userID'];
                    $info['eID'] = (int)$data['eID'];
                    $info['dID'] = (int)$value;
                    $Department->insert( 'employee_department', $info );
                }
            }
            $Department->delete( 'employee_department', 'WHERE userID = "' . (int)$data['userID'] . '" AND 
                                    dID NOT IN(' . addslashes( implode( ',', $data['department'] ) ) . ')' );
        }
    }
}
?>