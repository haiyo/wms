<?php
namespace Aurora\User;

    /**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: UserImage.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserImage extends \DAO {


    // Properties


    /**
    * Return total count of records
    * @return int
    */
    public function isFound( $userID ) {
        $sql = $this->DB->select( 'SELECT COUNT(userID) FROM user WHERE userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
    * Retrieve a user column by userID
    * @return mixed
    */
    public function getByUserID( $userID ) {
        $sql = $this->DB->select( 'SELECT * FROM user_image ui
                                   LEFT JOIN upload up ON (ui.uID = up.uID)
                                   WHERE ui.userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }
}
?>