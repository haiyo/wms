<?php
namespace Aurora\User;
use \Application\DAO\DAO;

    /**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: UserImage.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserImage extends DAO {


    // Properties

    
    /**
    * UserImage Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
	}


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
    public function getByUserID( $userID, $column ) {
        $sql = $this->DB->select( 'SELECT ' . addslashes( $column ) . ' FROM user_image ui
                                   LEFT JOIN upload u ON (ui.uID = u.uID)
                                   WHERE ui.userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }
}
?>