<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Race.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Race extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $rID ) {
        $sql = $this->DB->select( 'SELECT COUNT(rID) FROM race WHERE rID = "' . (int)$rID . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getList( ) {
        $sql = $this->DB->select( 'SELECT * FROM race', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['rID']] = $row['name'];
            }
        }
        return $list;
    }


    /**
     * Retrieve a user column by userID
     * @return int
     */
    public function getListCount( $list ) {
        $sql = $this->DB->select( 'SELECT COUNT(rID) FROM race 
                                   WHERE rID IN (' . addslashes( $list ) . ')',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }
}
?>