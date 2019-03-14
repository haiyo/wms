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
    public function isFound( $edID ) {
        return $this->Department->isFound( $edID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID, $dID ) {
        return $this->Department->isFoundByUserID( $userID, $dID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getByUserID( $userID ) {
        return $this->Department->getByUserID( $userID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->Department->getList( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function save( $data ) {
        if( isset( $data['department'] ) && is_array( $data['department'] ) && isset( $data['userID'] ) && $data['userID'] ) {
            $DepartmentModel = new \Aurora\Component\DepartmentModel( );

            foreach( $data['department'] as $value ) {
                if( $DepartmentModel->isFound( $value ) && !$this->isFoundByUserID( $data['userID'], $value ) ) {
                    $info = array( );
                    $info['userID'] = (int)$data['userID'];
                    $info['eID'] = (int)$data['eID'];
                    $info['dID'] = (int)$value;
                    $this->Department->insert( 'employee_department', $info );
                }
            }
            $this->Department->delete( 'employee_department', 'WHERE userID = "' . (int)$data['userID'] . '" AND 
                                        dID NOT IN(' . addslashes( implode( ',', $data['department'] ) ) . ')' );
        }
    }
}
?>