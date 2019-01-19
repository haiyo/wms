<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Race.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Upload extends \DAO {


    // Properties


    /**
     * Race Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $uID, $hashName ) {
        $sql = $this->DB->select( 'SELECT COUNT(uID) FROM upload 
                                   WHERE uID = "' . (int)$uID . '" AND 
                                         hashName = "' . addslashes( $hashName ) . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getByUIDHashName( $uID, $hashName ) {
        $sql = $this->DB->select( 'SELECT * FROM upload 
                                   WHERE uID = "' . (int)$uID . '" AND 
                                         hashName = "' . addslashes( $hashName ) . '"',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Return a list of all users
     * @return mixed
     */
    public function getByUID( $uID ) {
        $sql = $this->DB->select( 'SELECT * FROM upload WHERE uID = "' . (int)$uID . '"',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getList( ) {
        $sql = $this->DB->select( 'SELECT * FROM upload', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['uID']] = $row;
            }
        }
        return $list;
    }
}
?>