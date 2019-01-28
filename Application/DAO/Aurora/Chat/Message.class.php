<?php
namespace Aurora\Chat;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Message.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Message extends \DAO {


    // Properties


    /**
     * Message Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getCUID( $crID, $userID ) {
        $sql = $this->DB->select( 'SELECT cuID FROM chat_user
                                   WHERE crID = "' . (int)$crID . '" AND 
                                         userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }
}
?>