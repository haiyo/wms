<?php
namespace Markaxis\Company;
use \Aurora\User\UserModel, \Aurora\Component\DesignationModel;
use \Library\Validator\Validator;
use \Library\Validator\ValidatorModule\IsEmpty;
use \Library\Exception\ValidatorException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, July 4th, 2012
 * @version $Id: LOAModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LOAModel extends \Model {


    // Properties
    protected $LOA;


    /**
     * LOAModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->LOA = new LOA( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $loaID ) {
        return $this->LOA->isFound( $loaID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByLoaID( $loaID ) {
        return $this->LOA->getByLoaID( $loaID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getContentByDesignationID( $dID ) {
        return $this->LOA->getContentByDesignationID( $dID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        $this->LOA->setLimit( $post['start'], $post['length'] );

        $order = 'lastUpdated';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'name';
                    break;
                case 2:
                    $order = 'lastUpdated';
                    break;
            }
        }
        $results = $this->LOA->getResults( $post['search']['value'], $order . $dir );
        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$post['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }


    /**
     * Set Content Info
     * @return bool
     */
    public function isValid( $data ) {
        $Validator = new Validator( );

        $this->info['loaID'] = (int)$data['loaID'];
        $this->info['content'] = Validator::stripTrimSelectedTags( $data['loaContent'], array( 'script' ) );

        $Validator->addModule('content', new IsEmpty( $this->info['content'] ) );

        try {
            $Validator->validate( );

            if( !isset( $data['designation'] ) || !is_array( $data['designation'] ) ) {
                $this->setErrMsg( $this->L10n->getContents('LANG_ENTER_REQUIRED_FIELDS') );
                return false;
            }

            $this->info['designation'] = $data['designation'];
        }
        catch( ValidatorException $e ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_ENTER_REQUIRED_FIELDS') );
            return false;
        }
        return true;
    }


    /**
     * Save Content information
     * @return int
     */
    public function save( ) {
        $validIDs = $info = array( );

        $info['userID'] = UserModel::getInstance( )->getInfo( )['userID'];
        $info['content'] = $this->info['content'];
        $info['lastUpdated'] = date( 'Y-m-d H:i:s' );

        if( !$this->info['loaID'] ) {
            $this->info['loaID'] = $this->LOA->insert( 'loa', $info );
        }
        else {
            $this->LOA->update('loa', $info, 'WHERE loaID = "' . (int)$this->info['loaID'] . '"' );
        }

        $DesignationModel = new DesignationModel( );
        $info = array( );
        $info['loaID'] = $this->info['loaID'];

        foreach( $this->info['designation'] as $dID ) {
            if( $DesignationModel->isFound( $dID ) ) {
                $info['designationID'] = (int)$dID;
                array_push( $validIDs, $this->LOA->insert( 'loa_designation', $info ) );
            }
        }

        if( sizeof( $validIDs ) > 0 ) {
            $validIDs = implode(',', $validIDs );
            $this->LOA->delete('loa_designation','WHERE loaID = "' . (int)$this->info['loaID'] . '" AND 
                                                            loadID NOT IN(' . addslashes( $validIDs ) . ')');
        }

        return $this->info['loaID'];
    }


    /**
     * Delete Pay Item
     * @return int
     */
    public function delete( $loaID ) {
        if( $this->isFound( $loaID ) ) {
            $this->LOA->delete( 'loa', 'WHERE loaID = "' . (int)$loaID . '"' );
        }
    }
}
?>