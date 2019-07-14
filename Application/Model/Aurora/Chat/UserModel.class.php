<?php
namespace Aurora\Chat;
use \Aurora\User\UserModel as AuroraUserModel;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Wednesday, July 4th, 2012
 * @version $Id: UserModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserModel extends \Model {


    // Properties
    protected $User;
    protected $userInfo;


    /**
     * UserModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );

        $this->User = new User( );
        $this->userInfo = AuroraUserModel::getInstance( )->getInfo( );
    }


    /**
     * Return list by userID
     * @return mixed
     */
    public function getCUID( $crID, $userID ) {
        return $this->User->getCUID( $crID, $userID );
    }


    /**
     * Mark all as read
     * @return int
     */
    public function isValid( $data ) {
        if( $data['crID'] ) {
            if( $data['isNewRoom'] ) {
                if( is_array( $data['users'] ) ) {
                    foreach( $data['users'] as $userID ) {
                        $this->addUser( $data['crID'], $userID );
                    }
                }
                // Finally add the owner ID;
                return $this->addUser( $data['crID'], $this->userInfo['userID'] );
            }

            // Not new room, check if user is found in the room...
            if( $cuID = $this->getCUID( $data['crID'], $this->userInfo['userID'] ) ) {
                return $cuID;
            }
            else {
                // Not a new room but user not invited! Ignore!
                return false;
            }
        }
    }


    /**
     * Add new user
     * @return int
     */
    public function addUser( $crID, $userID ) {
        $info = array( );
        $info['crID'] = (int)$crID;
        $info['userID'] = (int)$userID;
        return $this->User->insert( 'chat_user', $info );
    }
}
?>