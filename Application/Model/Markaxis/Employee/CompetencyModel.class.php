<?php
namespace Markaxis\Employee;
use \Aurora\User\UserImageModel, Aurora\Component\CompetencyModel AS A_CompetencyModel;
use \Library\Util\MXString;
use \Library\Validator\Validator;
use \Library\Validator\ValidatorModule\IsEmpty;
use \Library\Exception\ValidatorException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: CompetencyModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CompetencyModel extends \Model {


    // Properties
    protected $Competency;


    /**
     * CompetencyModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->Competency = new Competency( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundBycID( $cID ) {
        return $this->Competency->isFoundBycID( $cID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID, $cID ) {
        return $this->Competency->isFoundByUserID( $userID, $cID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getBycID( $cID ) {
        return $this->Competency->getBycID( $cID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByUserID( $userID ) {
        return $this->Competency->getByUserID( $userID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getCountList( $cID ) {
        $list = $this->Competency->getCountList( $cID );

        if( sizeof( $list ) > 0 ) {
            $UserImageModel = UserImageModel::getInstance( );

            foreach( $list as $key => $value ) {
                $list[$key]['image'] = $UserImageModel->getImgLinkByUserID( $list[$key]['userID'] );
            }
        }
        return $list;
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        $this->Competency->setLimit( $post['start'], $post['length'] );

        $order = 'c.competency';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'c.competency';
                    break;
            }
        }
        $results = $this->Competency->getResults( $post['search']['value'], $order . $dir );

        $MXString = new MXString( );

        foreach( $results as $key => $row ) {
            if( isset( $results[$key]['descript'] ) && $results[$key]['descript'] ) {
                $results[$key]['descript'] = nl2br( $MXString->makeLink( $row['descript'], 200 ) );
            }
        }

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

        $this->info['cID'] = (int)$data['competencyID'];
        $this->info['competency'] = Validator::stripTrim( $data['competency'] );
        $this->info['descript'] = Validator::stripTrim( $data['competencyDescript'] );

        $Validator->addModule( 'competency', new IsEmpty( $this->info['competency'] ) );
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
     * Save Competency
     * @return int
     */
    public function saveCompetency( ) {
        if( !$this->info['cID'] ) {
            unset( $this->info['cID'] );
            $this->info['cID'] = $this->Competency->insert( 'competency', $this->info );
        }
        else {
            $this->Competency->update( 'competency', $this->info, 'WHERE cID = "' . (int)$this->info['cID'] . '"' );
        }
        return $this->info['cID'];
    }


    /**
     * Save Employee Competencies
     * @return void
     */
    public function save( $data ) {
        // Array with cID passthru from Component\CompetencyModel
        if( isset( $data['competency'] ) && is_array( $data['competency'] ) ) {
            $A_CompetencyModel = A_CompetencyModel::getInstance( );
            $validcID = array( );

            foreach( $data['competency'] as $cID ) {
                if( $A_CompetencyModel->isFoundBycID( $cID ) ) {
                    if( !$this->isFoundByUserID( $data['userID'], $cID ) ) {
                        $info = array( );
                        $info['userID'] = (int)$data['userID'];
                        $info['eID'] = (int)$data['eID'];
                        $info['cID'] = (int)$cID;
                        $this->Competency->insert( 'employee_competency', $info );
                    }
                }
                array_push( $validcID, $cID );
            }
            $competency = implode( ',', $validcID );

            if( $competency )
                $this->Competency->delete( 'employee_competency', 'WHERE userID = "' . (int)$data['userID'] . '" AND 
                                            cID NOT IN(' . addslashes( $competency ) . ')' );
        }
    }


    /**
     * Delete Pay Item
     * @return int
     */
    public function delete( $data ) {
        $deleted = 0;

        if( is_array( $data['data'] ) ) {
            foreach( $data['data'] as $cID ) {
                $info = array( );
                $info['deleted'] = 1;
                $this->Competency->update( 'competency', $info, 'WHERE cID = "' . (int)$cID . '"' );
                $deleted++;
            }
        }
        return $deleted;
    }
}
?>