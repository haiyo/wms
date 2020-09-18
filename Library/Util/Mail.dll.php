<?php
namespace Library\Util;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: Mail.dll.class.php, v 2.0 Exp $
 */

class Mail {


    // Properties
    protected $to;
    protected $from;
    protected $replyTo;
    protected $cc;
    protected $bcc;
    protected $headers;
    protected $subject;
    protected $body;
    protected $msg;


    /**
    * Constructor
    * @returns void
    */
    function __construct( $to, $from, $subject, $body, $replyTo='', $cc='', $bcc='' ) {
    	$this->to      = trim( $to      );
    	$this->cc      = trim( $cc      );
        $this->bcc     = trim( $bcc     );
        $this->from    = trim( $from    );
    	$this->replyTo = trim( $replyTo );
        $this->subject = trim( $subject );
        $this->body    = trim( $body    );
    }

    
    /**
    * Extra Mailing Headers
    * @returns void
    */
    public function extraHeaders( ) {
    	if( strlen( trim( $this->from    ) ) != 0 ) $this->headers .= 'From:     ' . $this->from;
    	if( strlen( trim( $this->replyTo ) ) != 0 ) $this->headers .= 'Reply-To: ' . $this->replyTo;
        if( strlen( trim( $this->cc      ) ) != 0 ) $this->headers .= 'Cc:       ' . $this->cc;
    	if( strlen( trim( $this->bcc     ) ) != 0 ) $this->headers .= 'Bcc:      ' . $this->bcc;
    }
    

    /**
    * Send Mail
    * @returns bool
    */
    public function sendMail( ) {
        $this->extraHeaders( );

        if( @mail( $this->to, $this->subject, $this->body, implode( "\r\n", $this->headers ) ) ) {
            return true;
        }
        else {
            die( 'Unable to send mail. Check mail server.' );
            return false;
        }
    }
}
?>