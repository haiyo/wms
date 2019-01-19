<?php
namespace Markaxis\Employee;
use \Aurora\User\UserModel;
use \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: SupervisorModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class SupervisorModel extends \Model {


    // Properties
    protected $Supervisor;


    /**
     * SupervisorModel Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();
        $i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->Supervisor = new Supervisor( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID, $seID ) {
        return $this->Supervisor->isFoundByUserID( $userID, $seID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getByUserID( $userID ) {
        return $this->Supervisor->getByUserID( $userID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getNameByUserID( $userID ) {
        return $this->Supervisor->getNameByUserID( $userID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function save( $data ) {
        // Make sure userID has "passed" from UserModel before proceed
        if( isset( $data['supervisors'] ) && isset( $data['userID'] ) && $data['userID'] ) {
            $supervisors = explode( ';', $data['supervisors'] );

            if( sizeof( $supervisors ) > 0 ) {
                $UserModel = new UserModel( );
                $success = array( );

                $existing = $this->getByUserID( $data['userID'] );

                foreach( $supervisors as $value ) {
                    $value = Validator::stripTrim( $value );

                    if( $value && $userInfo = $UserModel->getFieldByName( $value, 'userID' ) ) {
                        if( !isset( $existing[$userInfo['userID']] ) ) {
                            $info = array( );
                            $info['userID'] = (int)$data['userID'];
                            $info['supUserID'] = (int)$userInfo['userID'];
                            $this->Supervisor->insert( 'employee_supervisor', $info );
                        }
                        array_push( $success, $userInfo['userID'] );
                    }
                }
                if( sizeof( $success ) > 0 ) {
                    $this->Supervisor->delete( 'employee_supervisor', 'WHERE userID = "' . (int)$data['userID'] . '" AND 
                                               supUserID NOT IN(' . addslashes( implode( ',', $success ) ) . ')' );
                }
            }
        }
    }
}
?>