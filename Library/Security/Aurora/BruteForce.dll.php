<?php
namespace Library\Security\Aurora;
use \Library\Runtime\Registry, \Library\Util\Aurora\MailManager;
use \Library\Util\IP;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Tuesday, July 31, 2012
 * @version $Id: BruteForce.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class BruteForce {


    // Properties
    private $Registry;
    private $HKEY_LOCAL;
    private $logFile;
    private $bfWindow;
    private $cache;
    private $ip;
    private $ipHash;


    /**
    * BruteForce Constructor
    * @returns void
    */
    function __construct( ) {
        $this->Registry = Registry::getInstance( );
        $this->HKEY_LOCAL = $this->Registry->get( HKEY_LOCAL );

        $this->logFile  = LOG_DIR . 'brutelog.php';
        $this->bfWindow = $this->HKEY_LOCAL['bfAction']*60;
        
        if( !file_exists( $this->logFile ) ) {
            touch( $this->logFile );
            $this->cache = array( );
        }
        else {
            $this->cache = unserialize( file_get_contents( $this->logFile ) );
        }
        $IP = new IP( );
        $this->ip = $IP->getAddress( );
        $this->ipHash = MD5( $this->ip );
        if( $this->cache) $this->cleanUp( );
	}


    /**
    * Check if current IP exceeded the limit number of failed attempts in the last X minutes
    * @return bool
    */
    public function isExceeded( ) {
        if( isset( $this->cache[$this->ipHash] ) ) {
            if( $this->cache[$this->ipHash]['attempt'] >= $this->HKEY_LOCAL['bfNumFailed'] ) {
                if( ( $this->cache[$this->ipHash]['time']+$this->bfWindow ) > time( ) ) {
                    $this->sendAlert( );
                    return true;
                }
            }
        }
        return false;
    }


    /**
    * Log the current IP on failed
    * @return bool
    */
    public function logIP( ) {
        if( !isset( $this->cache[$this->ipHash] ) ) {
            $this->cache[$this->ipHash] = array( 'time'    => time( ),
                                                 'mail'    => 0,
                                                 'attempt' => 1 );
        }
        else if( $this->cache[$this->ipHash]['attempt'] < $this->HKEY_LOCAL['bfNumFailed'] ) {
            $this->cache[$this->ipHash] = array( 'time'    => time( ),
                                                 'mail'    => 0,
                                                 'attempt' => ($this->cache[$this->ipHash]['attempt']+1) );
        }
        $this->cleanUp( );
    }


    /**
    * Send email alert if not already sent
    * @return bool
    */
    public function sendAlert( ) {
        if( !$this->cache[$this->ipHash]['mail'] && $this->HKEY_LOCAL['bfAlert'] ) {
            $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
            $L10n = $i18n->loadLanguage( 'Aurora/Config/BFLoginRes' );

            $MailManager = new MailManager( );
            $MailManager->isFromSystem( );
            $MailManager->setSubject( $L10n->getContents('LANG_ALERT_SUBJECT') );

            $replace = array( $this->ip, $this->HKEY_LOCAL['bfNumFailed'], $this->HKEY_LOCAL['bfAction'] );
            $search  = array( '{ip_address}','{num_failed}','{bf_action}' );
            $MailManager->setMsg( str_replace( $search, $replace, $L10n->getContents('LANG_ALERT_MSG') ) );
            $MailManager->send( );
            $this->cache[$this->ipHash]['mail'] = 1;
        }
    }


    /**
    * Performs a clear on current IP if login successful
    * @return void
    */
    public function clearCurrent( ) {
        if( isset( $this->cache[$this->ipHash] ) ) {
            unset( $this->cache[$this->ipHash] );
            $file = fopen( $this->logFile, 'w' );
            fwrite( $file, serialize( $this->cache ) );
            fclose( $file );
        }
    }


    /**
    * Performs cleanup on cache
    * @return void
    */
    public function cleanUp( ) {
        if( isset( $this->cache[$this->ipHash] ) &&
          ( $this->cache[$this->ipHash]['time']+$this->bfWindow ) < time( ) ) {
            unset( $this->cache[$this->ipHash] );
        }
        echo serialize( $this->cache );
        $file = fopen( $this->logFile, 'w' );
        fwrite( $file, serialize( $this->cache ) );
        fclose( $file );
    }
}
?>