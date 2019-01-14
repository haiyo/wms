<?php
namespace Markaxis\Company;
use \Library\IO\File;
use \Date, \Validator, \IsEmpty, \IsEmail, \ValidatorException;
/**
 * @author Andy L.W.L <support@markaxis.com>
  * @since Saturday, August 4th, 2012
 * @version $Id: CompanyModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CompanyModel extends \Model {


    // Properties
    protected $Company;


    /**
    * CompanyModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/User/UserRes');

        File::import( DAO . 'Markaxis/Company/Company.class.php' );
        $this->Company = new Company( );

        $this->info['companyRegNo'] = $this->info['companyName'] = $this->info['companyAddress'] =
        $this->info['companyEmail'] = $this->info['companyPhone'] = $this->info['companyWebsite'] =
        $this->info['companyType'] = $this->info['companyCountry'] = '';
	}


    /**
    * Return total count of records
    * @return int
    */
    public function loadInfo( ) {
        return $this->info = $this->Company->loadInfo( );
    }


    /**
    * Set User Property Info
    * @return bool
    */
    public function isValid( $data ) {
        File::import( LIB . 'Util/Date.dll.php' );
        File::import( LIB . 'Validator/Validator.dll.php' );
        File::import( LIB . 'Validator/ValidatorModule/IsEmpty.dll.php' );
        File::import( LIB . 'Validator/ValidatorModule/IsEmail.dll.php' );
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
        $this->info['address2'] = Validator::stripTrim( $data['address2'] );
        $this->info['phone']    = Validator::stripTrim( $data['phone'] );
        $this->info['mobile']   = Validator::stripTrim( $data['mobile'] );
        $this->info['children'] = (int)$data['children'];
        //$this->info['image']    = $info['image'];

        $data['loginPassword'] = Validator::stripTrim( $data['loginPassword'] );

        if( $data['loginPassword'] ) {
            $this->info['password'] = password_hash( $data['loginPassword'], PASSWORD_DEFAULT );
        }

        if( isset( $data['gender'] ) ) {
            $this->info['gender'] = $data['gender'] == 'm' ? 'm' : 'f';
        }
        else {
            $this->info['gender'] = '';
        }

        if( in_array( $data['nationality'], NationalityHelper::getL10nList( ) ) ) {
            $this->info['nationality'] = $data['nationality'];
        }

        if( isset( $data['religion'] ) ) {
            File::import( MODEL . 'Aurora/Component/ReligionModel.class.php' );
            $ReligionModel = ReligionModel::getInstance( );
            if( $ReligionModel->isFound( $data['religion'] ) ) {
                $this->info['religionID'] = $data['religion'];
            }
        }

        if( isset( $data['race'] ) ) {
            File::import( MODEL . 'Aurora/Component/RaceModel.class.php' );
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


        File::import( MODEL . 'Aurora/Component/CountryModel.class.php' );
        $CountryModel = CountryModel::getInstance( );
        if( $CountryModel->isFound( $data['country'] ) ) {
            $this->info['country'] = (int)$data['country'];
        }

        File::import( MODEL . 'Aurora/Component/StateModel.class.php' );
        $StateModel = StateModel::getInstance( );
        if( $StateModel->isFound( $data['state'] ) ) {
            $this->info['state'] = (int)$data['state'];
        }

        File::import( MODEL . 'Aurora/Component/CityModel.class.php' );
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
        $userID = $this->info['userID'];
        unset( $this->info['userID'] );

        if( $userID == 0 ) {
            $this->info['created'] = date( 'Y-m-d H:i:s' );
            $this->info['userID'] = $this->User->insert( 'user', $this->info );

            File::import( DAO . 'Aurora/User/UserLog.class.php' );
            $UserLog = new UserLog( );
            $UserLog->insert( 'user_log', array( 'userID' => $this->info['userID'] ) );
        }
        else {
            $this->info['lastUpdate'] = date( 'Y-m-d H:i:s' );
            $this->User->update( 'user', $this->info, 'WHERE userID="' . (int)$userID . '"' );
            $this->info['userID'] = $userID;

            $this->info['updateCurrent'] = false;
            $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
            $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

            if( $userInfo['userID'] == $this->info['userID'] ) {
                $this->info['updateCurrent'] = true;
            }
        }
        return $this->info['userID'];
    }
}
?>