<?php
namespace Markaxis\Leave;
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
    public function getSuggestToken( $userID ) {
        return $this->Manager->getSuggestToken( $userID );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getHistory( $list ) {
        if( isset( $list['data'] ) ) {
            foreach( $list['data'] as $key => $value ) {
                $list['data'][$key]['managers'] = $this->Manager->getBylaID( $value['laID'] );
            }
        }
        return $list;
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function save( $data ) {
        $hasSup = false;

        // Make sure userID has "passed" from UserModel before proceed
        if( isset( $data['managers'] ) && isset( $data['laID'] ) && $data['laID'] ) {
            $managers = explode( ';', $data['managers'] );

            if( sizeof( $managers ) > 0 ) {
                $UserModel = new UserModel( );

                foreach( $managers as $value ) {
                    $value = Validator::stripTrim( $value );

                    if( $value && $userInfo = $UserModel->getFieldByName( $value, 'userID' ) ) {
                        $info = array( );
                        $info['laID'] = (int)$data['laID'];
                        $info['managerID'] = (int)$userInfo['userID'];
                        $this->Manager->insert( 'leave_apply_manager', $info );
                        $hasSup = true;
                    }
                }
            }
        }
        return $hasSup;
    }
}
?>