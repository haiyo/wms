<?php
namespace Library\Util;

define( 'ERR_CANNOT_OPEN_FILE', 'Unable to  open specified file.' );

/**
 * @author Andy L.W.L <andylam@hwzcorp.com>
 * @since Saturday, February 19, 2005
 * @version $Id: Main.class.php, v 1.0 Exp $
 */
Class MimeMail extends Mail {


    var $type;

    var $charset;

    var $encoding;

    var $attachment;

    var $attachFile;

    var $mimeType;

    var $mimeVersion;

    var $mailer;

    var $boundary;


    /**
     * Application Constructor
     * The main core application settings & classes will be register here.
     * Performs connection to database & passing important instances to the
     * registry.
     * @returns void
     */
    function __construct( $to, $from, $subject, $body, $replyTo='', $cc='', $bcc='' ) {
        parent::Mail( $to, $from, $subject, $body, $replyTo, $cc, $bcc );

        $this->type        = 'text/html';
        $this->charset     = 'us-ascii';
        $this->encoding    = '8bit';
        $this->attachment  = 0;
        $this->attachFile  = array();
        $this->mimeType    = 'application/octet-stream';
        $this->mimeVersion = 'MIME-Version: 1.0';
        $this->mailer      = 'Markmas Mailer Management System 1.0';
    }


    /**
     * Application Constructor
     * The main core application settings & classes will be register here.
     * Performs connection to database & passing important instances to the
     * registry.
     * @returns void
     */
    function buildMimeHeaders( ) {
        $this->headers[] = 'X-Mailer: ' . $this->mailer;
        $this->headers[] = $this->mimeVersion;

        if( $this->attachment ) {
            $this->boundary = MD5( uniqid( time() ) );

            $this->headers[] = 'Content-Type: multipart/mixed; boundary="' . $this->boundary . '"' . "\r\n";
            $this->headers[] = '--' . $this->boundary;
        }

        $this->headers[] = 'Content-Type: ' . $this->type . '; charset="' . $this->charset . '";';
        $this->headers[] = 'Content-Transfer-Encoding: ' . $this->encoding;
    }


    /**
     * Application Constructor
     * The main core application settings & classes will be register here.
     * Performs connection to database & passing important instances to the
     * registry.
     * @returns void
     */
    function buildMimeBody( ) {
        if( !$this->attachment ) return true;

        $body_parts    = array();
        $body_parts[0] .= $this->body . "\r\n\r\n";

        for( $i = 0; $i < count( $this->attachFile ); $i++ ) {
            if( !$fp = @fopen( $this->attachFile[$i]['file'], 'r' ) ) {
                $this->ERROR_MSG = ERR_CANNOT_OPEN_FILE . ' ' . $this->attachFile[$i]['file'];
                return false;
            }

            $file_body = fread( $fp, filesize( $this->attachFile[$i]['file'] ) );
            $file_body = chunk_split( base64_encode( $file_body ) );

            $body_parts[$i + 1] = '--' . $this->boundary . "\r\n";

            if( !empty( $this->files[$i]['filetype'] ) ) {
                $this->mimeType = $this->attachFile[$i]['filetype'];
            }

            $body_parts[$i + 1] .= 'Content-Type: ' . $this->mimeType . '; name="' . basename( $this->attachFile[$i]['filename'] ) . '"' . "\r\n";
            $body_parts[$i + 1] .= 'Content-Transfer-Encoding: base64' . "\r\n\r\n";
            $body_parts[$i + 1] .= $file_body . "\r\n\r\n";

            /* Insert Company Signature Here If Needed */
        }
        $body_parts[$i + 1] .= '--' . $this->boundary . '--';
        $this->body = implode( "", $body_parts );

        return true;
    }


    /**
     * Application Constructor
     * The main core application settings & classes will be register here.
     * Performs connection to database & passing important instances to the
     * registry.
     * @returns void
     */
    function returnAll( ) {
        if( count( $this->attachFile ) > 0 ) $this->attachment = true;

        $this->headers = array();
        $this->buildMimeHeaders();

        $this->headers[] = 'From:     ' . $this->from;
        $this->headers[] = 'Reply-To: ' . $this->replyTo;
        $this->headers[] = 'To:       ' . $this->to;
        $this->headers[] = 'Subject:  ' . $this->subject;
        $this->headers[] = 'Cc:       ' . $this->cc;
        $this->headers[] = 'Bcc:      ' . $this->bcc;

        $msg = implode( "\r\n", $this->headers );
        $msg .= "\r\n\r\n";
        $msg .= $this->body;

        return $msg;
    }


    /**
     * Application Constructor
     * The main core application settings & classes will be register here.
     * Performs connection to database & passing important instances to the
     * registry.
     * @returns void
     */
    function sendmail( ) {
        if( count( $this->attachFile ) > 0 ) $this->attachment = true;

        $this->subject = stripslashes( trim( $this->subject ) );
        $this->body    = stripslashes( $this->body );

        Mail::extraHeaders();
        $this->buildMimeHeaders();

        @mail( $this->to, $this->subject, trim( $this->body ), implode( "\r\n", $this->headers ) );
    }
}

?>