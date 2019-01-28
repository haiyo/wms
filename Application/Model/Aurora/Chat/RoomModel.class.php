<?php
namespace Aurora\Chat;
use \Aurora\User\UserModel;
use \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, July 4th, 2012
 * @version $Id: RoomModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class RoomModel extends \Model {


    // Properties
    protected $Room;
    protected $userInfo;


    /**
     * RoomModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->Room = new Room( );
        $this->userInfo = UserModel::getInstance( )->getInfo( );
    }


    /**
     * Return list by userID
     * @return mixed
     */
    public function isFound( $crID ) {
        return $this->Room->isFound( $crID );
    }


    /**
     * Create room
     * @return array
     */
    public function create( $data ) {
        if( isset( $data['crID'] ) && isset( $data['users'] ) && isset( $data['message'] ) ) {
            // First check if message is even empty, don't waste time if so..
            $message = Validator::stripTrim( $data['message'] );

            if( $message ) {
                if( $this->isFound( $data['crID'] ) ) {
                    // return existing room
                    return array( 'crID' => (int)$data['crID'], 'isNewRoom' => false );
                }
                else if( $data['crID'] == 0 ) {
                    // Check the list of users are valid
                    $validCount = UserModel::getInstance( )->getListValidCount( $data['users'] );
                    $users = explode(',', $data['users'] );

                    // Only create new room if all userIDs are valid!
                    if( $validCount == count( $users ) ) {
                        // create new room
                        $info = array( );
                        $info['userID'] = $this->userInfo['userID'];
                        $info['created'] = date( 'Y-m-d H:i:s' );
                        $crID = $this->Room->insert( 'chat_room', $info );
                        return array( 'crID' => $crID, 'users' => $users, 'isNewRoom' => true );
                    }
                }
            }
        }
        // Either no crID or crID > 0 but not found, trying to be funny!
        return array( 'crID' => false );
    }


    /**
     * Add new notification
     * @return int

    public function notify( $nID, $userID ) {
        $info = array( );
        $info['nID']      = (int)$nID;
        $info['userID']   = (int)$this->userInfo['userID'];
        $info['toUserID'] = (int)$userID;
        $info['created']  = date( 'Y-m-d H:i:s' );
        return $this->Notification->insert( 'notification_user', $info );
    } */
}
?>