<?php
namespace Markaxis\Employee;
use \Aurora\User\UserModel;
use \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ManagerModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ManagerModel extends \Model {


    // Properties
    protected $Manager;


    /**
     * ManagerModel Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();
        $i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->Manager = new Manager( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID, $seID ) {
        return $this->Manager->isFoundByUserID( $userID, $seID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getByUserID( $userID ) {
        return $this->Manager->getByUserID( $userID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getNameByUserID( $userID ) {
        return $this->Manager->getNameByUserID( $userID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function save( $data ) {
        // Make sure userID has "passed" from UserModel before proceed
        if( isset( $data['managers'] ) && isset( $data['userID'] ) && $data['userID'] ) {
            $managers = explode( ';', $data['managers'] );

            if( sizeof( $managers ) > 0 ) {
                $UserModel = new UserModel( );
                $success = array( );

                $existing = $this->getByUserID( $data['userID'] );

                foreach( $managers as $value ) {
                    $value = Validator::stripTrim( $value );

                    if( $value && $userInfo = $UserModel->getFieldByName( $value, 'userID' ) ) {
                        if( !isset( $existing[$userInfo['userID']] ) ) {
                            $info = array( );
                            $info['userID'] = (int)$data['userID'];
                            $info['managerID'] = (int)$userInfo['userID'];
                            $this->Manager->insert( 'employee_manager', $info );
                        }
                        array_push( $success, $userInfo['userID'] );
                    }
                }
                if( sizeof( $success ) > 0 ) {
                    $this->Manager->delete('employee_manager', 'WHERE userID = "' . (int)$data['userID'] . '" AND 
                                             managerID NOT IN(' . addslashes( implode( ',', $success ) ) . ')' );
                }
            }
        }
    }
}
?>