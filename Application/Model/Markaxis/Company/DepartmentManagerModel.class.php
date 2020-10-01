<?php
namespace Markaxis\Company;
use \Markaxis\Employee\ManagerModel;

/**
 * @author Andy L.W.L <support@markaxis.com>
  * @since Saturday, August 4th, 2012
 * @version $Id: DepartmentManagerModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DepartmentManagerModel extends \Model {


    // Properties
    private $DepartmentManager;
    private $validManagerID;


    /**
    * DepartmentManagerModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->DepartmentManager = new DepartmentManager( );
	}


    /**
     * Return all manager(s) by current userID
     * @return mixed
     */
    public function getBydID( $dID ) {
        return $this->DepartmentManager->getBydID( $dID );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function getSuggestToken( $dID ) {
        return $this->getBydID( $dID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getDepartmentResults( $list ) {
        if( isset( $list['data'] ) ) {
            foreach( $list['data'] as $key => $value ) {
                $list['data'][$key]['managers'] = $this->DepartmentManager->getBydID( $value['dID'] );
            }
        }
        return $list;
    }


    /**
     * Set Pay Item Info
     * @return bool
     */
    public function isValid( $data ) {
        if( isset( $data['dID'] ) ) {
            $ManagerModel = ManagerModel::getInstance( );

            if( $ManagerModel->isValid( $data ) ) {
                $this->info['dID'] = $data['dID'];
                $this->validManagerID = $ManagerModel->getValidManagerID( );
                return true;
            }
            else {
                $this->errMsg = $ManagerModel->getErrMsg( );
            }
        }
        return false;
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function save( ) {
        if( sizeof( $this->validManagerID ) > 0 && isset( $this->info['dID'] ) ) {
            $success = array( );

            // Get all managers by department ID
            $existing = $this->getBydID( $this->info['dID'] );

            foreach( $this->validManagerID as $managerID ) {
                if( !isset( $existing[$managerID] ) ) {
                    $info = array( );
                    $info['departmentID'] = (int)$this->info['dID'];
                    $info['userID'] = (int)$managerID;
                    $this->DepartmentManager->insert( 'department_manager', $info );
                }
                array_push( $success, $managerID );
            }
            if( sizeof( $success ) > 0 ) {
                $this->DepartmentManager->delete('department_manager',
                                                'WHERE departmentID = "' . (int)$this->info['dID'] . '" AND 
                                                  userID NOT IN(' . addslashes( implode( ',', $success ) ) . ')' );
            }
        }
        else {
            $this->DepartmentManager->delete('department_manager','WHERE departmentID = "' . (int)$this->info['dID'] . '"' );
        }
    }


    /**
     * Delete Pay Item
     * @return int
     */
    public function delete( $dID ) {
        $this->DepartmentManager->delete('department_manager',
                                        'WHERE departmentID = "' . (int)$dID . '"' );
    }
}
?>