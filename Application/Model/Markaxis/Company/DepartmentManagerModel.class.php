<?php
namespace Markaxis\Company;

/**
 * @author Andy L.W.L <support@markaxis.com>
  * @since Saturday, August 4th, 2012
 * @version $Id: DepartmentManagerModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DepartmentManagerModel extends \Model {


    // Properties
    protected $DepartmentManager;


    /**
    * DepartmentManagerModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->DepartmentManager = new DepartmentManager( );
	}


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        $this->Department->setLimit( $post['start'], $post['length'] );

        $order = 'name';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'name';
                    break;
                case 2:
                    $order = 'address';
                    break;
                case 3:
                    $order = 'country';
                    break;
                case 4:
                    $order = 'staff';
                    break;
            }
        }

        $results = $this->Department->getResults( $post['search']['value'], $order . $dir );

        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$post['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }


    /**
     * Set Pay Item Info
     * @return bool
     */
    public function isValid( $data ) {
        if( isset( $data['dID'] ) && $data['dID'] ) {
            $this->info['dID'] = (int)$data['dID'];
            return true;
        }
        return false;
    }


    /**
     * Save Pay Item information
     * @return int
     */
    public function save( ) {
        if( !$this->info['dID'] ) {
            unset( $this->info['dID'] );
            $this->info['dID'] = $this->DepartmentManager->insert( 'department_manager', $this->info );
        }
        else {
            $this->DepartmentManager->update( 'department_manager', $this->info, 'WHERE dID = "' . (int)$this->info['dID'] . '"' );
        }
        return $this->info['dID'];
    }


    /**
     * Delete Pay Item
     * @return int

    public function delete( $dID ) {
        $A_DepartmentModel = A_DepartmentModel::getInstance( );

        if( $A_DepartmentModel->isFound( $dID ) ) {
            $info = array( );
            $info['deleted'] = 1;
            $this->Department->update( 'department', $info, 'WHERE dID = "' . (int)$dID . '"' );
        }
    } */
}
?>