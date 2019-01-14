<?php
namespace Library\Security\Aurora;
use \Aurora\User\UserModel;
use \Library\Exception\Aurora\AuthLoginException;
use \Library\IO\File, \Library\Http\HttpRequest, \Library\Http\HttpResponse;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: Authenticator.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Authenticator {


    // Properties
    protected $Registry;
    protected $UserModel;
    protected $Session;
    protected $authField;


    /**
    * Authenticator Constructor
    * @returns void
    */
    function __construct( ) {
        $this->Registry  = Registry::getInstance( );
        
        File::import( MODEL . 'Aurora/User/UserModel.class.php' );
        $this->UserModel = UserModel::getInstance( );
	}


    /**
    * Return User Model Object
    * @return obj
    */
    public function getUserModel( ) {
        return $this->UserModel;
    }


    /**
    * Performs authentication
    * @throws AuthLoginException
    * @return bool
    */
    public function login( HttpRequest $Request, HttpResponse $Response ) {
        $userInfo = $this->UserModel->getFieldByUsername( $Request->request( POST, 'username' ), 'userID, password' );

        if( $userInfo && password_verify( $Request->request( POST, 'password' ), $userInfo['password'] ) ) {
            $Session = $this->Registry->get( HKEY_CLASS, 'Session' );
            $Session->setSession( $userInfo['userID'] );

            $this->Registry->setCookie( 'userID',   $userInfo['userID'] );
            $this->Registry->setCookie( 'sessHash', $Session->getSessHash( ) );
            return true;
        }
        else {
            $Response->setCode( HttpResponse::HTTP_EXPECTATION_FAILED );
            throw( new AuthLoginException( HttpResponse::HTTP_EXPECTATION_FAILED, $Request ) );
        }
    }


    /**
    * Performs logout
    * @return void
    */
    public function logout( HttpResponse $Response ) {
        $Session = $this->Registry->get( HKEY_CLASS, 'Session' );
        $UserLog = $this->Registry->get( HKEY_CLASS, 'UserLog' );
        $UserLog->updateStatus( $Session->getUserID( ), 0 );
        $Session->destroy( );

        $time = mktime( 0, 0, 0, 1, 1, 1970 );
        $Response->setCookie( 'userID',   '', $time );
        $Response->setCookie( 'sessHash', '', $time );
    }
}
?>