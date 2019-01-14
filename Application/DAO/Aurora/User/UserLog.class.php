<?php
namespace Aurora\User;
use \Library\IO\File;
use \Library\Util\UserAgent, \Library\Util\IP;
/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: UserLog.class.php, v 2.0 Exp $
 * @desc User Log Management
*/

class UserLog extends \DAO {


    // Properties
    protected $userLog;


    /**
    * Constructor
    * @returns void
    */
    function __construct( ) {
        parent::__construct( );
        $this->userLog = array( );
    }


    /**
    * Get notification from Observable
    * @access public
    * @returns void
    */
    public function notify( $sender, $event ) {
        if( $event == 'getUser' ) {
            $userInfo = $sender->getUserInfo( );

            if( sizeof( $userInfo ) > 0 ) {
                foreach( $userInfo as $userID => $row ) {
                    $userInfo[$userID]['userlog'] = $this->getUserLog( $userID );
                }
                $sender->setUserInfo( $userInfo );
            }
        }
        if( $event == 'addUser' ) {
            File::import( LIB . 'Util/IP.dll.php' );
            $UserAgent = new UserAgent( );
            $DefIP = new IP( );
            $this->userLog['userID']    = $sender->getUserInfo( 'userID' );
            $this->userLog['ipAddress'] = $DefIP->getAddress( );
            $this->userLog['hostName']  = gethostbyaddr( $this->userLog['ipAddress'] );
            $this->userLog['userAgent'] = $UserAgent->getUserAgent( );
            $this->addUserLog( );
        }
    }


    /**
    * Return user log property
    * @access public
    * @returns mixed[]
    */
    public function getUserLogInfo( $infoType=NULL ) {
        if( !is_null( $infoType ) && isset( $this->userLog[$infoType] ) ) {
            return $this->userLog[$infoType];
        }
        return $this->userLog;
    }


    /**
    * Load user avatar to class
    * @access public
    * @return void
    */
    public function getUserLog( $userID ) {
        $list = array( );
        $sql = $this->DB->select( 'SELECT * FROM user_log
                                   WHERE userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            $list = $this->DB->fetch( $sql );
        }
        return $list;
    }
    
    
    /**
    * Retrieve user log particular field from DB
    * @access public
    * @returns str
    */
    public function getField( $userID, $column ) {
        $sql = $this->DB->select( 'SELECT ' . addslashes( $column ) . ' FROM user_log
                                   WHERE userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            $row = $this->DB->fetch( $sql );
            return $row[$column];
        }
    }
    
    
    /**
    * Load user log to class
    * @access public
    * @returns void
    */
    public function load( $userID ) {
        $sql = $this->DB->select( 'SELECT * FROM user_log WHERE
                                   userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            $this->userLog = $this->DB->fetch( $sql );
            return true;
        }
        return false;
    }
    
    
    /**
    * Return true or false based on particular column
    * @access public
    * @returns bool
    */
    public function isFound( $field, $value ) {
        $sql = $this->DB->select( 'SELECT COUNT(userID) FROM user_log
                                   WHERE ' . addslashes( $field ) . ' = "' . addslashes( $value ) . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
    * Update user offline/onlines status 0/1
    * @access public
    * @returns void
    */
    public function updateStatus( $userID, $status ) {
        $logInfo = array( );

        if( $status ) {
            File::import( LIB . 'Util/IP.dll.php' );
            $UserAgent = new UserAgent( );
            $IP = new IP( );
            $logInfo['ipAddress'] = $IP->getAddress( );
            $logInfo['hostName']  = gethostbyaddr( $logInfo['ipAddress'] );
            $logInfo['userAgent'] = $UserAgent->getUserAgent( );
            $logInfo['isOnline']  = 1;
            $logInfo['online']    = time( );
        }
        else {
            $logInfo['isOnline'] = 0;
            $logInfo['online']   = time( );
            $logInfo['last']     = time( );
        }
        return $this->update( 'user_log', $logInfo, 'WHERE userID = "' . (int)$userID . '"' );
    }
}
?>