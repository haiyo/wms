<?php
namespace Aurora;
use \Aurora\User\UserModel;
use \Library\Util\Aurora\MailManager;
use \Library\Validator\Validator;
use \Library\Validator\ValidatorModule\IsEmpty, \Library\Validator\ValidatorModule\IsEmail;
use \Library\Exception\ValidatorException;

/**
 * @author Andy L.W.L <support@markaxis.com>
  * @since Saturday, August 4th, 2012
 * @version $Id: ForgotPasswordModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ForgotPasswordModel extends \Model {


    // Properties
    protected $ForgotPassword;


    /**
    * ForgotPasswordModel Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );

        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Aurora/ForgotPasswordRes');
        $this->UserL10n = $i18n->loadLanguage('Aurora/User/UserRes');

        $this->ForgotPassword = new ForgotPassword( );
	}


    /**
     * Set User Property Info
     * @return bool
     */
    public function getByToken( $token ) {
        return $this->ForgotPassword->getByToken( $token );
    }


    /**
     * Set User Property Info
     * @return bool
     */
    public function isValidToken( $token ) {
        if( $tokenInfo = $this->getByToken( $token ) ) {
            $a = new \DateTime( $tokenInfo['created'] );
            $b = new \DateTime( '-1 day' );
            $diff = $a->diff( $b );

            if( $diff->days >= 1 ) {
                $this->setErrMsg( $this->L10n->getContents( 'LANG_TOKEN_EXPIRED' ) );
                return false;
            }
            return $tokenInfo;
        }
        return false;
    }


    /**
    * Set User Property Info
    * @return bool
    */
    public function isValidEmail( $email ) {
        $Validator = new Validator( );
        $this->info['email']  = Validator::stripTrim( $email );
        $Validator->addModule( 'email1', new IsEmail( $this->info['email'] ) );

        try {
            $Validator->validate( );
        }
        catch( ValidatorException $e ) {
            if( $e->getModuleName( ) == 'email' ) {
                $this->setErrMsg( $this->UserL10n->getContents( 'LANG_INVALID_EMAIL' ) );
                return false;
            }
        }
        $UserModel = new UserModel( );
        return $UserModel->getFieldByEmail( $this->info['email'], '*' );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function sendForgotPasswordLink( $email ) {
        if( $userInfo = $this->isValidEmail( $email ) ) {

            $info = array( );
            $info['userID'] = $userInfo['userID'];
            $info['token']  = MD5( microtime( ) . rand( ) );
            $info['created'] = date( 'Y-m-d H:i:s' );

            if( $this->ForgotPassword->insert('forgot_password', $info ) ) {
                $local = $this->Registry->get( HKEY_LOCAL );

                $MailManager = new MailManager( );
                $MailManager->setDebug(2);
                $MailManager->isFromSystem( );
                $MailManager->setSubject( 'Forgotten Password' );

                $emailTxt = $this->L10n->strReplace( 'TOKEN', $info['token'], 'LANG_RESET_PASSWORD_EMAIL' );
                $emailTxt = $this->L10n->strReplace( 'MAIL_FROM', $local['mailFromEmail'], $emailTxt );
                $MailManager->setMsg( $emailTxt );

                if( $MailManager->send( ) ) {
                    $MailManager->getMailerObject( )->outPutError('Mailer Error: ' . $MailManager->getMailerObject( )->ErrorInfo);
                    return true;
                }
                else {
                    $this->setErrMsg( 'Mailer Error: ' . $MailManager->getMailerObject( )->ErrorInfo );
                }
            }
        }
        return false;
    }


    /**
     * Set User Property Info
     * @return bool
     */
    public function changePassword( $data ) {
        if( $tokenInfo = $this->isValidToken( $data['token'] ) ) {
            $Validator = new Validator( );
            $Validator->addModule( 'password', new IsEmpty( $data['password'] ) );

            try {
                $Validator->validate( );
            }
            catch( ValidatorException $e ) {
                $this->setErrMsg( $this->L10n->getContents('LANG_PASSWORD_CANNOT_EMPTY') );
                return false;
            }

            if( $data['password'] == $data['cPassword'] ) {
                $info = array( );
                $info['password'] = password_hash( $data['password'],PASSWORD_DEFAULT );

                $User = new \Aurora\User\User( );
                $User->update( 'user', $info, 'WHERE userID = "' . (int)$tokenInfo['userID'] . '"' );

                $this->ForgotPassword->delete('forgot_password', 'WHERE fpID = "' . (int)$tokenInfo['fpID'] . '"' );
                return true;
            }
        }
        return false;
    }
}
?>