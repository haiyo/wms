<?php
namespace Aurora\Chat;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: User.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class User extends \DAO {


    // Properties


    /**
     * User Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Return chat user ID
     * @return int
     */
    public function getCUID( $crID, $userID ) {
        $sql = $this->DB->select( 'SELECT cuID FROM chat_user
                                   WHERE crID = "' . (int)$crID . '" AND 
                                         userID = "' . (int)$userID . '" AND
                                         hasLeft = "0" AND isRemoved = "0"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            $row = $this->DB->fetch( $sql );
            return $row['cuID'];
        }
        return false;
    }
}
?>