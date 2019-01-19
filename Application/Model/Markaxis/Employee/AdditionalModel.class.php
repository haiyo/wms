<?php
namespace Markaxis\Employee;
use \Aurora\Component\RecruitSourceModel;
use \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: AdditionalModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class AdditionalModel extends \Model {


    // Properties
    protected $Additional;


    /**
     * AdditionalModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $this->info['resume'] = $this->info['notes'] = '';

        $this->Additional = new Additional( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID ) {
        return $this->Additional->isFoundByUserID( $userID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByUserID( $userID, $column ) {
        return $this->Additional->getByUserID( $userID, $column );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function save( $data ) {
        $this->info['notes'] = Validator::stripTrim( $data['notes'] );

        if( isset( $data['recruitSource'] ) ) {
            $RecruitSourceModel = RecruitSourceModel::getInstance( );

            if( $RecruitSourceModel->isFound( $data['recruitSource'] ) ) {
                $this->info['rsID'] = (int)$data['recruitSource'];
            }
        }

        if( $this->isFoundByUserID( $data['userID'] ) ) {
            $this->Additional->update( 'employee_additional', $this->info, 'WHERE userID = "' . (int)$data['userID'] . '"' );
        }
        else {
            $this->info['userID'] = (int)$data['userID'];
            $this->info['eID'] = (int)$data['eID'];
            $this->Additional->insert('employee_additional', $this->info);
        }
    }
}
?>