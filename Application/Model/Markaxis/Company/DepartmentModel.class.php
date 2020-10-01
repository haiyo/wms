<?php
namespace Markaxis\Company;
use \Aurora\Component\DepartmentModel AS A_DepartmentModel;
use \Library\Validator\Validator;
use \Library\Validator\ValidatorModule\IsEmpty;
use \Library\Exception\ValidatorException;

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
    public function getList( ) {
        $A_DepartmentModel = A_DepartmentModel::getInstance( );
        return $A_DepartmentModel->getList( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getBydID( $dID ) {
        $A_DepartmentModel = A_DepartmentModel::getInstance( );
        return $A_DepartmentModel->getByID( $dID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        $this->Department->setLimit( $post['start'], $post['length'] );

        $order = 'd.name';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'd.name';
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
        $Validator = new Validator( );

        $this->info['dID'] = (int)$data['departmentID'];
        $this->info['name'] = Validator::stripTrim( $data['departmentName'] );

        $Validator->addModule( 'departmentName', new IsEmpty( $this->info['name'] ) );

        try {
            $Validator->validate( );
        }
        catch( ValidatorException $e ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_ENTER_REQUIRED_FIELDS') );
            return false;
        }
        return true;
    }


    /**
     * Save Pay Item information
     * @return int
     */
    public function save( ) {
        if( !$this->info['dID'] ) {
            unset( $this->info['dID'] );
            $this->info['dID'] = $this->Department->insert( 'department', $this->info );
        }
        else {
            $this->Department->update( 'department', $this->info, 'WHERE dID = "' . (int)$this->info['dID'] . '"' );
        }
        return $this->info['dID'];
    }


    /**
     * Delete Pay Item
     * @return int
     */
    public function delete( $dID ) {
        $A_DepartmentModel = A_DepartmentModel::getInstance( );

        if( $A_DepartmentModel->isFoundByID( $dID ) ) {
            $info = array( );
            $info['deleted'] = 1;
            return $this->Department->update( 'department', $info, 'WHERE dID = "' . (int)$dID . '"' );
        }
        return false;
    }
}
?>