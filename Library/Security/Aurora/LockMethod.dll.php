<?php
namespace Library\Security\Aurora;
use \Library\Exception\Aurora\AuthLoginException;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LockMethod.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LockMethod extends Authenticator {


    protected $userInfo;
    protected $logFile;
    protected $lock;
    protected $lockWindow = 1*60; // set 1 hour; to move to Registry if have demand;


    /**
    * LockMethod Constructor
    * @returns void
    */
    function __construct( ) {
        parent::__construct( );
        $this->userInfo = $this->UserModel->getInfo( );

        $this->logFile = LOG_DIR . 'lock.php';

        if( !file_exists( $this->logFile ) ) {
            touch( $this->logFile );
            $this->lock = array( );
        }
        else {
            $this->lock = unserialize( file_get_contents( $this->logFile ) );
        }
	}


    /**
    * Performs authentication
    * @throws AuthLoginException
    * @return bool
    */
    public function verify( $password ) {
        if( $this->userInfo && $this->login( $this->userInfo['username'], $password, false ) ) {
            return true;
        }
        return false;
    }


    /**
     * Performs authentication
     * @throws AuthLoginException
     * @return bool
     */
    public function allow( $method ) {
        if( sizeof( $this->lock ) > 0 ) {
            if( isset( $this->lock[$method] ) ) {
                // Regardless who using it if more than an hour, invalidate lock
                if( ( $this->lock[$method]['time']+$this->lockWindow ) < time( ) ) {
                    unset( $this->lock[$method] );
                    return true;
                }
                // Someone still using it
                if( $this->lock[$method]['userID'] != $this->userInfo['userID'] ) {
                    return false;
                }
            }
        }
        return true;
    }


    /**
     * Performs authentication
     * @throws AuthLoginException
     * @return bool
     */
    public function logEntry( $method ) {
        $this->lock[$method] = array( 'userID' => $this->userInfo['userID'],
                                      'time' => time( ) );

        $file = fopen( $this->logFile, 'w' );
        fwrite( $file, serialize( $this->lock ) );
        fclose( $file );
    }
}
?>