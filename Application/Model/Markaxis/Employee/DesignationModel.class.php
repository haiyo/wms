<?php
namespace Markaxis\Employee;
use \Library\Validator\Validator;
use \Library\Validator\ValidatorModule\IsEmpty;
use \Library\Exception\ValidatorException;

/**
 * @author Andy L.W.L <support@markaxis.com>
  * @since Saturday, August 4th, 2012
 * @version $Id: DesignationModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class DesignationModel extends \Model {


    // Properties
    protected $Designation;


    /**
    * DesignationModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->Designation = new Designation( );
	}


    /**
    * Return total count of records
    * @return int
    */
    public function getList( ) {
        return $this->Designation->getList( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getGroupList( ) {
        return $this->Designation->getGroupList( );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        $this->Designation->setLimit( $post['start'], $post['length'] );

        $order = 'parentTitle';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'parentTitle';
                    break;
            }
        }
        $results = $this->Designation->getResults( $post['search']['value'], $order . $dir );

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

        if( $data['group'] ) {
            $moduleName = 'groupTitle';
            $this->info['dID'] = (int)$data['data']['groupID'];
            $this->info['title'] = Validator::stripTrim( $data['data']['groupTitle'] );
            $this->info['descript'] = '';
            $this->info['parent'] = 0;
        }
        else {
            $moduleName = 'designationTitle';
            $this->info['dID'] = (int)$data['data']['designationID'];
            $this->info['title'] = Validator::stripTrim( $data['data']['designationTitle'] );
            $this->info['descript'] = Validator::stripTrim( $data['data']['designationDescript'] );
            $this->info['parent'] = (int)$data['data']['dID'];
        }

        $Validator->addModule( $moduleName, new IsEmpty( $this->info['title'] ) );

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
            $this->info['dID'] = $this->Designation->insert( 'designation', $this->info );
        }
        else {
            $this->Designation->update( 'designation', $this->info, 'WHERE dID = "' . (int)$this->info['dID'] . '"' );
        }
        return $this->info['dID'];
    }


    /**
     * Delete Pay Item
     * @return int
     */
    public function delete( $data ) {
        $deleted = 0;

        if( is_array( $data ) ) {
            foreach( $data as $dID ) {
                $this->Designation->delete('designation', 'WHERE dID = "' . (int)$dID . '"');
                $deleted++;
            }
        }
        return $deleted;
    }
}
?>