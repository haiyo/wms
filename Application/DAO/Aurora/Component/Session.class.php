<?php
namespace Aurora\Component;
use \Application\DAO\DAO;
use \Library\Http\HttpRequest, \Library\Util\UserAgent;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: Session.class.php, v 2.0 Exp $
 */

class Session extends DAO {


    // Properties
    protected $userID;
    protected $sessHash;
    protected $lastOnline;


    /**
    * Session Constructor
    * @returns void
    */
    function __construct( ) {
        parent::__construct( );

        $HttpRequest = new HttpRequest( );
        $this->userID   = (int)$HttpRequest->request( COOKIE, 'userID'   );
        $this->sessHash =      $HttpRequest->request( COOKIE, 'sessHash' );
    }
    
    
    /**
    * Return userID
    * @return int
    */
    public function getUserID( ) {
        return $this->userID;
    }


    /**
    * Return Session Hash
    * @return str
    */
    public function getSessHash( ) {
        return $this->sessHash;
    }


    /**
    * Returns whether the current user have a session. If so, authenticate.
    * @returns bool
    */
    public function isFound( ) {
        if( (int)$this->userID != 0 && !empty( $this->sessHash ) ) {
            return true;
        }
        return false;
    }

    
    /**
    * Set User Session
    * @return void
    */
    public function setSession( $userID ) {
        $this->userID  = (int)$userID;
        $this->sessHash = $this->write( );
    }


    /**
    * Session Authentication
    * @returns bool
    */
    public function authHash( ) {
        $sql = $this->DB->select( 'SELECT s.token FROM session s, user u
                                   WHERE s.userID = "' . (int)$this->userID . '" AND
                                         u.userID = s.userID AND
                                         u.suspended != "1" AND
                                         s.session = "' . addslashes( $this->sessHash ) . '"',
                                         __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            $row = $this->DB->fetch( $sql );

            $UserAgent = new UserAgent( );
            $sessHash = MD5( $row['token'] . $_SERVER['REMOTE_ADDR'] );
            $sessHash = MD5( $sessHash . $UserAgent->getUserAgent( ) );

            if( $sessHash == $this->sessHash ) {
                return true;
            }
        }
        return false;
    }


    /**
    * Update An Existing Session
    * @return void
    */
    public function updateSession( ) {
        $var = array( );
        $var['time'] = (int)time( );
        $this->update( 'session', $var, 'WHERE userID = "' . (int)$this->userID . '"' );
    }


    /**
    * Logging Session Activities To Database
    * @return string
    */
    public function write( ) {
        $this->destroy( );
        $UserAgent = new UserAgent( );

        $SQL = array( );
        $SQL['userID']  = (int)$this->userID;
        $SQL['token']   = MD5( uniqid( microtime( ) ) );
        $SQL['session'] = MD5( $SQL['token'] . $_SERVER['REMOTE_ADDR'] );
        $SQL['session'] = MD5( $SQL['session'] . $UserAgent->getUserAgent( ) );
        $SQL['time']    = time( );
        $this->insert( 'session', $SQL );
        return $SQL['session'];
    }


    /**
    * Destroy Expired Session
    * @return void
    */
    public function deleteExpire( $expired ) {
        // Delete less than x seconds
        $this->DB->select( 'DELETE FROM session WHERE time < ' . (int)$expired,
                            __FILE__, __LINE__ );
    }


    /**
    * Session Destroy
    * @public
    * @return void
    */
    public function destroy( ) {
        $this->DB->delete( 'DELETE FROM session WHERE userID = "' . (int)$this->userID . '"',
                            __FILE__, __LINE__ );
    }
}
?>