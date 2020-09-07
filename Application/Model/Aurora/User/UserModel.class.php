<?php
namespace Aurora\User;
use \Library\Helper\Aurora\MaritalHelper;
use \Aurora\Component\ReligionModel, \Aurora\Component\RaceModel;
use \Aurora\Component\CountryModel, \Aurora\Component\StateModel, \Aurora\Component\CityModel;
use \Aurora\Component\AuditLogModel, \Aurora\Component\NationalityModel;
use \Library\Security\Aurora\Authenticator, \Library\Util\Date;
use \Library\Validator\Validator;
use \Library\Validator\ValidatorModule\IsEmpty, \Library\Validator\ValidatorModule\IsEmail;
use \Library\Exception\ValidatorException;

/**
 * @author Andy L.W.L <support@markaxis.com>
  * @since Saturday, August 4th, 2012
 * @version $Id: UserModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserModel extends \Model {


    // Properties
    protected $User;


    /**
    * UserModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $this->info['fname'] = $this->info['lname'] = $this->info['email1'] =
        $this->info['email2'] = $this->info['gender'] = $this->info['birthday'] =
        $this->info['countryID'] = $this->info['address1'] = $this->info['address2'] =
        $this->info['postal'] = $this->info['city'] = $this->info['state'] =
        $this->info['phone'] = $this->info['mobile'] = $this->info['nric'] =
        $this->info['marital'] = $this->info['nationalityID'] = $this->info['username'] =
        $this->info['image'] = '';

        $this->info['userID'] = $this->info['suspended'] = $this->info['deleted'] =
        $this->info['children'] = '0';

        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->User = new User( );
	}


    /**
    * Return total count of records
    * @return int
    */
    public function isFound( $userID ) {
        return $this->User->isFound( $userID );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getCurrUser( ) {
        $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
        $userInfo  = $Authenticator->getUserModel( )->getInfo( 'userInfo' );
        return $this->User->getFieldByUserID( $userInfo['userID'], '*' );
    }


    /**
    * Return a list of all users
    * @return mixed
    */
    public function getAllUser( ) {
        return $this->User->getAllUser( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getEvents( $info ) {
        $eventList = array( );

        if( isset( $info['start'] ) && isset( $info['end'] ) ) {
            $startDate = Date::parseDateTime( $info['start'] );
            $endDate = Date::parseDateTime( $info['end'] );
            $eventList = $this->User->getEvents( $startDate, $endDate );

            foreach( $eventList as $key => $event ) {
                $eventList[$key]['title'] = $event['name'] . ' ' . $this->L10n->getContents('LANG_BIRTHDAY');
            }
        }
        return $eventList;
    }


    /**
    * Load user to class
    * @return void
    */
    public function load( $userID ) {
        $this->info = $this->User->getFieldByUserID( $userID, '*' );
    }


    /**
    * Return user data by userID
    * @return mixed
    */
    public function getFieldByUserID( $userID, $column ) {
        return $this->User->getFieldByUserID( $userID, $column );
    }


    /**
    * Return user data by email
    * @return mixed
    */
    public function getFieldByEmail( $email, $column ) {
        return $this->User->getFieldByEmail( $email, $column );
    }


    /**
     * Search name
     * @return mixed
     */
    public function getFieldByUsername( $username, $column ) {
        return $this->User->getFieldByUsername( $username, $column );
    }


    /**
     * Search name
     * @return mixed
     */
    public function getFieldByName( $name, $column ) {
        return $this->User->getFieldByName( $name, $column );
    }


    /**
     * Search name
     * @return mixed
     */
    public function getListValidCount( $userIDs ) {
        return $this->User->getListValidCount( $userIDs );
    }


    /**
    * Set User Property Info
    * @return bool
    */
    public function isValid( $data ) {
        $Validator = new Validator( );

        $this->info['userID']  = (int)$data['userID'];
        $this->info['fname']   = Validator::stripTrim( $data['fname'] );
        $this->info['lname']   = Validator::stripTrim( $data['lname'] );
        $this->info['email1']  = Validator::stripTrim( $data['email1'] );

        $Validator->addModule( 'fname', new IsEmpty( $this->info['fname'] ) );
        $Validator->addModule( 'lname', new IsEmpty( $this->info['lname'] ) );
        $Validator->addModule( 'email1', new IsEmail( $this->info['email1'] ) );

        try {
            $Validator->validate( );
        }
        catch( ValidatorException $e ) {
            if( $e->getModuleName( ) == 'fname' || $e->getModuleName( ) == 'lname' ) {
                $this->setErrMsg( $this->L10n->getContents('LANG_ENTER_REQUIRED_FIELDS') );
                return false;
            }
            if( $e->getModuleName( ) == 'email1' ) {
                $this->setErrMsg( $this->L10n->getContents('LANG_INVALID_EMAIL') );
                return false;
            }
        }

        if( $this->info['userID'] == 0 && $this->getFieldByEmail( $this->info['email1'], 'email1' ) ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_EMAIL_ALREADY_EXIST') );
            return false;
        }

        $this->info['nric']     = Validator::stripTrim( $data['nric'] );
        $this->info['gender']   = isset( $data['gender'] ) ? Validator::stripTrim( $data['gender'] ) : '';
        $this->info['email2']   = Validator::stripTrim( $data['email2'] );
        $this->info['username'] = Validator::stripTrim( $data['loginUsername'] );
        $this->info['postal']   = Validator::stripTrim( $data['postal'] );
        $this->info['address1'] = Validator::stripTrim( $data['address1'] );
        //$this->info['address2'] = Validator::stripTrim( $data['address2'] );
        $this->info['phone']    = Validator::stripTrim( $data['phone'] );
        $this->info['mobile']   = Validator::stripTrim( $data['mobile'] );
        $this->info['children'] = (int)$data['children'];
        //$this->info['image']    = $info['image'];

        $data['loginPassword'] = Validator::stripTrim( $data['loginPassword'] );

        if( $data['loginPassword'] ) {
            try {
                $Authenticator = new Authenticator( );

                $encrypted = $Authenticator->getKeyManager( )->encrypt( $data['loginPassword'] );
                $this->info['password'] = $encrypted['data'];
                $this->info['kek'] = $encrypted['secret'];
            }
            catch( \Exception $e ) {
                die( $e );
            }
        }

        if( isset( $data['gender'] ) ) {
            $this->info['gender'] = $data['gender'] == 'm' ? 'm' : 'f';
        }
        else {
            $this->info['gender'] = '';
        }

        if( isset( $data['religion'] ) ) {
            $ReligionModel = ReligionModel::getInstance( );
            if( $ReligionModel->isFound( $data['religion'] ) ) {
                $this->info['religionID'] = $data['religion'];
            }
        }

        if( isset( $data['race'] ) ) {
            $RaceModel = RaceModel::getInstance( );
            if( $RaceModel->isFound( $data['race'] ) ) {
                $this->info['raceID'] = $data['race'];
            }
        }

        if( in_array( $data['marital'], MaritalHelper::getList( ) ) ) {
            $this->info['marital'] = $data['marital'];
        }

        if( $data['userID'] == 0 && $this->info['username'] &&
            $this->getFieldByUsername( $this->info['username'], 'username' ) ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_USERNAME_ALREADY_EXIST') );
            return false;
        }

        $dobDay   = (int)Validator::stripTrim( $data['dobDay'] );
        $dobMonth = (int)Validator::stripTrim( $data['dobMonth'] );
        $dobYear  = (int)Validator::stripTrim( $data['dobYear'] );

        if( !$this->info['birthday'] = Date::getDateStr( $dobMonth, $dobDay, $dobYear ) ) {
            unset( $this->info['birthday'] );
        }

        $CountryModel = CountryModel::getInstance( );
        if( $CountryModel->isFound( $data['country'] ) ) {
            $this->info['countryID'] = (int)$data['country'];
        }

        $NationalityModel = NationalityModel::getInstance( );
        if( $NationalityModel->isFound( $data['nationality'] ) ) {
            $this->info['nationalityID'] = (int)$data['nationality'];
        }

        $StateModel = StateModel::getInstance( );
        if( $StateModel->isFound( $data['state'] ) ) {
            $this->info['state'] = (int)$data['state'];
        }

        $CityModel = CityModel::getInstance( );
        if( $CityModel->isFound( $data['city'] ) ) {
            $this->info['city'] = (int)$data['city'];
        }
        return true;
    }


    /**
    * Save user account information
    * @return int
    */
    public function save( ) {
        if( !$this->info['userID'] ) {
            unset( $this->info['userID'] );
            $this->info['created'] = date( 'Y-m-d H:i:s' );
            $this->info['userID'] = $this->User->insert( 'user', $this->info );

            $UserLog = new UserLog( );
            $UserLog->insert( 'user_log', array( 'userID' => $this->info['userID'] ) );
        }
        else {
            $this->info['lastUpdate'] = date( 'Y-m-d H:i:s' );
            $this->User->update( 'user', $this->info, 'WHERE userID = "' . (int)$this->info['userID'] . '"' );

            $this->info['updateCurrent'] = false;
            $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
            $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

            if( $userInfo['userID'] == $this->info['userID'] ) {
                $this->info['updateCurrent'] = true;
            }
        }
        return $this->info['userID'];
    }


    /**
    * Delete user account
    * @return int
    */
    public function delete( $userID ) {
        $info = array( );
        $info['deleted'] = 1;
        $this->User->update( 'user', $info, 'WHERE userID = "' . (int)$userID . '"' );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function setSuspendStatus( $post ) {
        if( $this->User->isFound( $post['userID'] ) ) {
            $info = array( );
            $info['suspended'] = $post['status'] == 1 ? 1 : 0;;
            $this->User->update( 'user', $info, 'WHERE userID = "' . (int)$post['userID'] . '"' );

            $AuditLogModel = new AuditLogModel( );

            $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
            $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

            $info['fromUserID'] = $userInfo['userID'];
            $info['toUserID'] = $post['userID'];
            $info['eventType'] = 'employee';
            $info['action'] = $info['suspended'] ? 'suspend' : 'unsuspend';
            $info['descript'] = addslashes( $post['reason'] );
            $info['created'] = date( 'Y-m-d H:i:s' );
            unset( $info['suspended'] );
            $AuditLogModel->log( $info );
        }
    }
}
?>