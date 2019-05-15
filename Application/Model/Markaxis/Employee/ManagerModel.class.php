<?php
namespace Markaxis\Employee;
use \Aurora\User\UserModel;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ManagerModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ManagerModel extends \Model {


    // Properties
    private $Manager;
    private $validManagerID;


    /**
     * ManagerModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->Manager = new Manager( );
        $this->validManagerID = array( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID, $seID ) {
        return $this->Manager->isFoundByUserID( $userID, $seID );
    }


    /**
     * Return all manager(s) by current userID
     * @return mixed
     */
    public function getValidManagerID( ) {
        return $this->validManagerID;
    }


    /**
     * Return all manager(s) by current userID
     * @return mixed
     */
    public function getByUserID( $userID ) {
        return $this->Manager->getByUserID( $userID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getSuggestToken( $userID=false ) {
        if( !$userID ) {
            $userInfo = UserModel::getInstance( )->getInfo( );
            $userID = $userInfo['userID'];
        }
        return $this->Manager->getSuggestToken( $userID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function isValid( $data ) {
        if( isset( $data['managers'] ) ) {
            $managers = explode( ';', $data['managers'] );

            $UserModel = new UserModel( );

            foreach( $managers as $userID ) {
                if( $userID ) {
                    if( !$UserModel->isFound( $userID ) ) {
                        $this->errMsg = 'Invalid User!';
                        return false;
                    }
                    $this->validManagerID[] = (int)$userID;
                }
            }
            // userID is conditionally set so as we can reuse this method for
            // other classes. It's only applicable for saving employee data.
            if( isset( $data['userID'] ) ) {
                $this->info['userID'] = $data['userID'];
            }
            return true;
        }
        return false;
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function save( ) {
        // Make sure userID has "passed" from UserModel before proceed
        if( sizeof( $this->validManagerID ) > 0 && isset( $this->info['userID'] ) ) {
            $success = array( );

            // Get all managers by current userID
            $existing = $this->getByUserID( $this->info['userID'] );

            foreach( $this->validManagerID as $managerID ) {
                if( !isset( $existing[$managerID] ) ) {
                    $info = array( );
                    $info['userID'] = (int)$this->info['userID'];
                    $info['managerID'] = (int)$managerID;
                    $this->Manager->insert( 'employee_manager', $info );
                }
                array_push( $success, $managerID );
            }
            if( sizeof( $success ) > 0 ) {
                $this->Manager->delete('employee_manager', 'WHERE userID = "' . (int)$this->info['userID'] . '" AND 
                                              managerID NOT IN(' . addslashes( implode( ',', $success ) ) . ')' );
            }
        }
        else {
            $this->Manager->delete('employee_manager', 'WHERE userID = "' . (int)$this->info['userID'] . '"' );
        }
    }
}
?>