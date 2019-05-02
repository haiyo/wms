<?php
namespace Markaxis\Employee;
use \Aurora\User\UserImageModel, Aurora\Component\DesignationModel AS A_DesignationModel;
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
    public function getBydID( $dID ) {
        $A_DesignationModel = A_DesignationModel::getInstance( );
        return $A_DesignationModel->getByID( $dID );
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
     * Return total count of records
     * @return int
     */
    public function getEmptyGroupList( ) {
        return $this->Designation->getEmptyGroupList( );
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
     * Return total count of records
     * @return int
     */
    public function getCountList( $cID ) {
        $list = $this->Designation->getCountList( $cID );

        if( sizeof( $list ) > 0 ) {
            $UserImageModel = UserImageModel::getInstance( );

            foreach( $list as $key => $value ) {
                $list[$key]['image'] = $UserImageModel->getByUserID( $list[$key]['userID'], 'up.hashDir, up.hashName');
            }
        }
        return $list;
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
            $this->Designation->update( 'designation', $this->info,
                                        'WHERE dID = "' . (int)$this->info['dID'] . '"' );
        }
        return $this->info['dID'];
    }


    /**
     * Delete Pay Item
     * @return int
     */
    public function delete( $data ) {
        $deleted = 0;

        if( is_array( $data['data'] ) ) {
            foreach( $data['data'] as $dID ) {
                if( $data['group'] ) {
                    $this->Designation->delete('designation', 'WHERE parent = "' . (int)$dID . '"');
                }
                else {
                    $info = array( );
                    $info['deleted'] = 1;
                    $this->Designation->update( 'designation', $info, 'WHERE dID = "' . (int)$dID . '"' );
                }
                $deleted++;
            }
        }
        return $deleted;
    }


    /**
     * Delete Pay Item
     * @return int
     */
    public function deleteOrphanGroups( ) {
        $emptyGroups = $this->getEmptyGroupList( );
        $count = sizeof( $emptyGroups );

        if( $count > 0 ) {
            $this->Designation->delete('designation',
                                      'WHERE dID IN (' . implode( ',', $emptyGroups ) . ')');
        }
        return $count;
    }
}
?>