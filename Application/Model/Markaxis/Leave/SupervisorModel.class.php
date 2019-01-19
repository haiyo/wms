<?php
namespace Markaxis\Leave;
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
     * Get File Information
     * @return mixed
     */
    public function getHistory( $list ) {
        if( isset( $list['data'] ) ) {
            foreach( $list['data'] as $key => $value ) {
                $list['data'][$key]['supervisors'] = $this->Supervisor->getByLaID( $value['laID'] );
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
        if( isset( $data['supervisors'] ) && isset( $data['laID'] ) && $data['laID'] ) {
            $supervisors = explode( ';', $data['supervisors'] );

            if( sizeof( $supervisors ) > 0 ) {
                $UserModel = new UserModel( );

                foreach( $supervisors as $value ) {
                    $value = Validator::stripTrim( $value );

                    if( $value && $userInfo = $UserModel->getFieldByName( $value, 'userID' ) ) {
                        $info = array( );
                        $info['laID'] = (int)$data['laID'];
                        $info['supUserID'] = (int)$userInfo['userID'];
                        $this->Supervisor->insert( 'leave_apply_supervisor', $info );
                        $hasSup = true;
                    }
                }
            }
        }
        return $hasSup;
    }
}
?>