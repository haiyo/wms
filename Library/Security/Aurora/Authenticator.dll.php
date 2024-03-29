<?php
namespace Library\Security\Aurora;
use \Aurora\User\UserModel;
use \Library\IO\File;
use \Library\Exception\Aurora\AuthLoginException;
use \Library\Http\HttpResponse;
use \Library\Runtime\Registry;
use \Library\Helper\Google\KeyManagerHelper;

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
    protected $authField;


    /**
    * Authenticator Constructor
    * @returns void
    */
    function __construct( ) {
        $this->Registry  = Registry::getInstance( );
        $this->UserModel = UserModel::getInstance( );
	}


    /**
    * Return User Model Object
    * @return '\Aurora\User\UserModel'
    */
    public function getUserModel( ) {
        return $this->UserModel;
    }


    /**
    * Performs authentication
    * @throws AuthLoginException
    * @return bool
    */
    public function login( $username, $password, $setSession=true ) {
        try {
            $userInfo = $this->UserModel->getFieldByUsername( $username, 'userID, password, kek, suspended, deleted' );

            if( $userInfo && !$userInfo['suspended'] && !$userInfo['deleted'] ) {
                $KeyManagerHelper = new KeyManagerHelper( );
                $decrypted = $KeyManagerHelper->decrypt( $userInfo['kek'], $userInfo['password'] );

                if( $decrypted == $password ) {
                    if( $setSession ) {
                        $Session = $this->Registry->get( HKEY_CLASS, 'Session' );
                        $Session->setSession( $userInfo['userID'] );

                        $this->Registry->setCookie( 'userID',   $userInfo['userID'] );
                        $this->Registry->setCookie( 'sessHash', $Session->getSessHash( ) );
                    }
                    return true;
                }
            }
        }
        catch( \Exception $e ) {
            $line  = '[' . date( 'd/M/Y H:i:s' ) . '] User: (' . $username . ') ' . $e->getMessage( );
            File::write( LOG_DIR . 'error.php', $line, FILE_APPEND );
        }
        return false;
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