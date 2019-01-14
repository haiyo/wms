<?php
namespace Aurora\User;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Children.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Children extends \DAO {


    // Properties

    
    /**
    * Children Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
	}


    /**
    * Retrieve all user
    * @return mixed
    */
    public function isFoundByID( $userID, $ucID ) {
        $sql = $this->DB->select( 'SELECT COUNT(ucID) FROM user_children WHERE userID = "' . (int)$userID . '" AND 
                                   ucID = "' . (int)$ucID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
    * Retrieve a user list normally use for building select list
    * @return mixed
    */
    public function getByUserID( $userID ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT * FROM user_children WHERE userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }
}
?>