<?php
namespace Markaxis\Employee;
use \Library\IO\File;
use \Aurora\Component\RecruitSourceModel;
use \Validator;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: AdditionalModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AdditionalModel extends \Model {


    // Properties



    /**
     * AdditionalModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $this->info['resume'] = $this->info['notes'] = '';
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID ) {
        File::import(DAO . 'Markaxis/Employee/Additional.class.php');
        $Additional = new Additional( );
        return $Additional->isFoundByUserID( $userID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByUserID( $userID, $column ) {
        File::import(DAO . 'Markaxis/Employee/Additional.class.php');
        $Additional = new Additional( );
        return $Additional->getByUserID( $userID, $column );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function save( $data ) {
        $this->info['notes'] = Validator::stripTrim( $data['notes'] );

        if( isset( $data['recruitSource'] ) ) {
            File::import( MODEL . 'Aurora/Component/RecruitSourceModel.class.php' );
            $RecruitSourceModel = RecruitSourceModel::getInstance( );

            if( $RecruitSourceModel->isFound( $data['recruitSource'] ) ) {
                $this->info['rsID'] = (int)$data['recruitSource'];
            }
        }

        File::import(DAO . 'Markaxis/Employee/Additional.class.php');
        $Additional = new Additional( );

        if( $this->isFoundByUserID( $data['userID'] ) ) {
            $Additional->update( 'employee_additional', $this->info, 'WHERE userID = "' . (int)$data['userID'] . '"' );
        }
        else {
            $this->info['userID'] = (int)$data['userID'];
            $this->info['eID'] = (int)$data['eID'];
            $Additional->insert('employee_additional', $this->info);
        }
    }
}
?>