<?php
namespace Library\Util;
use \Library\IO\File;

define( 'ERR_CANNOT_OPEN_FILE', 'Unable to  open specified file.' );

/**
 * @author Andy L.W.L <andylam@hwzcorp.com>
 * @since Saturday, February 19, 2005
 * @version $Id: Main.class.php, v 1.0 Exp $
 */
class MimeMail extends Mail {


    // Properties
    protected $type;
    protected $charset;
    protected $encoding;
    protected $attachment;
    protected $attachFile;
    protected $mimeType;
    protected $mimeVersion;
    protected $mailer;
    protected $boundary;


    /**
     * Application Constructor
     * The main core application settings & classes will be register here.
     * Performs connection to database & passing important instances to the
     * registry.
     * @returns void
     */
    function __construct( $to, $from, $subject, $body, $replyTo='', $cc='', $bcc='' ) {
        parent::__construct( $to, $from, $subject, $body, $replyTo, $cc, $bcc );

        $this->type        = 'text/html';
        $this->charset     = 'us-ascii';
        $this->encoding    = '8bit';
        $this->attachFile  = array();
        $this->mimeType    = 'application/octet-stream';
        $this->mimeVersion = 'MIME-Version: 1.0';
        $this->mailer      = 'Markaxis Mailer Management System 1.0';
    }


    /**
     * Application Constructor
     * The main core application settings & classes will be register here.
     * Performs connection to database & passing important instances to the
     * registry.
     * @returns void
     */
    function attach( $fileArray ) {
        if( is_array( $fileArray ) ) {
            $this->attachFile = $fileArray;
        }
    }


    /**
     * Application Constructor
     * The main core application settings & classes will be register here.
     * Performs connection to database & passing important instances to the
     * registry.
     * @returns void
     */
    function buildMimeHeaders( ) {
        $this->headers .= 'X-Mailer: ' . $this->mailer;
        $this->headers .= $this->mimeVersion;

        if( sizeof( $this->attachFile ) > 0 ) {
            $this->boundary = MD5( uniqid( time() ) );

            $this->headers .= 'Content-Type: multipart/mixed; boundary="' . $this->boundary . '"';
            $this->headers .= '--' . $this->boundary;
        }

        $this->headers .= 'Content-Type: ' . $this->type . '; charset="' . $this->charset . '";';
        $this->headers .= 'Content-Transfer-Encoding: ' . $this->encoding;
    }


    /**
     * Application Constructor
     * The main core application settings & classes will be register here.
     * Performs connection to database & passing important instances to the
     * registry.
     * @returns void
     */
    function buildMimeBody( ) {
        if( sizeof( $this->attachFile ) == 0 ) return true;

        $body_parts = array( $this->body . "\r\n\r\n" );
        $sizeOf = count( $this->attachFile );

        for( $i=0; $i<$sizeOf; $i++ ) {
            if( !$fp = @fopen( $this->attachFile[$i], 'r' ) ) {
                $this->ERROR_MSG = ERR_CANNOT_OPEN_FILE . ' ' . $this->attachFile[$i];
                return false;
            }

            $file_body = fread( $fp, filesize( $this->attachFile[$i] ) );
            $file_body = chunk_split( base64_encode( $file_body ) );

            $body_parts[$i + 1] = '--' . $this->boundary . "\r\n";

            /*if( !empty( $this->files[$i]['filetype'] ) ) {
                $this->mimeType = $this->attachFile[$i]['filetype'];
            }*/

            $this->mimeType = File::getType( $this->attachFile[$i] );

            $body_parts[] .= 'Content-Type: ' . $this->mimeType . '; name="' . basename( $this->attachFile[$i] ) . '"' . "\r\n";
            $body_parts[] .= 'Content-Transfer-Encoding: base64' . "\r\n\r\n";
            $body_parts[] .= $file_body . "\r\n\r\n";

            /* Insert Company Signature Here If Needed */
        }
        $body_parts[] .= '--' . $this->boundary . '--';
        $this->body = implode("", $body_parts );

        return true;
    }


    /**
     * Application Constructor
     * The main core application settings & classes will be register here.
     * Performs connection to database & passing important instances to the
     * registry.
     * @returns void
     */
    function sendmail( ) {
        $this->subject = stripslashes( trim( $this->subject ) );
        $this->body    = stripslashes( $this->body );

        Mail::extraHeaders();
        $this->buildMimeHeaders();
        $this->buildMimeBody();

        @mail( $this->to, $this->subject, trim( $this->body ), $this->headers );
    }
}

?>