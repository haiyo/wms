<?php
namespace Library\Util\Aurora;
use PHPMailer\PHPMailer;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, August 1st, 2012
 * @version $Id: MailManager.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class MailManager {


    // Properties
    private $HKEY_LOCAL;
    private $PHPMailer;


    /**
    * MailManager Constructor
    * @return void
    */
    function __construct( ) {
        $Registry = Registry::getInstance( );
        $this->HKEY_LOCAL = $Registry->get( HKEY_LOCAL );

        $this->PHPMailer = new PHPMailer( );

        if( !$this->HKEY_LOCAL['enableSMTP'] ) {
            $this->PHPMailer->IsMail( );
        }
        else {
            $this->PHPMailer->IsSMTP( );
            $this->PHPMailer->Host = $this->HKEY_LOCAL['smtpAddress'];
            $this->PHPMailer->Port = $this->HKEY_LOCAL['smtpPort'];

            if( $this->HKEY_LOCAL['smtpConnect'] ) {
                $this->PHPMailer->SMTPSecure = $this->HKEY_LOCAL['smtpConnect'];
            }
            if( $this->HKEY_LOCAL['smtpUsername'] && $this->HKEY_LOCAL['smtpPassword'] ) {
                $this->PHPMailer->SMTPAuth = true;
                $this->PHPMailer->Username = $this->HKEY_LOCAL['smtpUsername'];
                $this->PHPMailer->Password = $this->HKEY_LOCAL['smtpPassword'];
            }
        }
	}


    /**
    * Returns the Mailer object
    * @return obj
    */
    public function getMailerObject( ) {
        return $this->PHPMailer;
    }


    /**
    * Set mailer debugging level
    * @return void
    */
    public function setDebug( $level ) {
        $this->PHPMailer->SMTPDebug = (int)$level;
    }


    /**
    * Send as HTML mail
    * @return void
    */
    public function setHTML( ) {
        $this->PHPMailer->IsHTML( true );
    }


    /**
    * Send mail using system email
    * @return void
    */
    public function isFromSystem( ) {
        $this->PHPMailer->SetFrom( $this->HKEY_LOCAL['mailFromEmail'], $this->HKEY_LOCAL['mailFromName'] );
        $this->PHPMailer->AddReplyTo( $this->HKEY_LOCAL['mailFromEmail'], $this->HKEY_LOCAL['mailFromName'] );

        $email = explode( "\r\n", $this->HKEY_LOCAL['mailFromEmail'] );
        if( is_array( $email ) ) {
            $first=1;
            while( list( , $value ) = each( $email ) ) {
                if( $first ) {
                    $this->sendTo( $value, $this->HKEY_LOCAL['mailFromEmail'] );
                    $first=0;
                }
                else {
                    $this->addCC( $value );
                }

            }
        }
    }


    /**
    * Set custom from and replyTo
    * @return void
    */
    public function setFrom( $email, $name ) {
        $this->PHPMailer->SetFrom( $email, $name );
        $this->PHPMailer->AddReplyTo( $email, $name );
    }


    /**
    * Set send to which email
    * @return void
    */
    public function sendTo( $email, $name='' ) {
        $this->PHPMailer->AddAddress( $email, $name );
    }


    /**
    * Add CC
    * @return void
    */
    public function addCC( $email, $name='' ) {
        $this->PHPMailer->AddCC( $email, $name );
    }


    /**
    * Add BCC
    * @return void
    */
    public function addBCC( $email, $name='' ) {
        $this->PHPMailer->AddBCC( $email, $name );
    }


    /**
    * Set Subject
    * @return void
    */
    public function setSubject( $subject ) {
        $this->PHPMailer->Subject = (string)$subject;
    }


    /**
    * Set Message
    * @return void
    */
    public function setMsg( $msg ) {
        $this->PHPMailer->MsgHTML( (string)$msg );
    }


    /**
    * Send mail
    * @return bool
    */
    public function send( ) {
        return $this->PHPMailer->Send( );
    }
}
?>