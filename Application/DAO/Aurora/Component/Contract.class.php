<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Contract.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Contract extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $cID ) {
        $sql = $this->DB->select( 'SELECT COUNT(cID) FROM contract 
                                   WHERE cID = "' . (int)$cID . '" AND deleted <> "1"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all user roles
     * @return mixed
     */
    public function getByID( $cID ) {
        $sql = $this->DB->select( 'SELECT * FROM contract WHERE cID = "' . (int)$cID . '" AND deleted <> "1"',
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
    public function getAll( ) {
        $sql = $this->DB->select( 'SELECT * FROM contract WHERE deleted <> "1"', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getList( ) {
        $sql = $this->DB->select( 'SELECT * FROM contract WHERE deleted <> "1"', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['cID']] = $row['type'];
            }
        }
        return $list;
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getIDList( ) {
        $sql = $this->DB->select( 'SELECT cID FROM contract WHERE deleted <> "1"', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['cID']] = $row;
            }
        }
        return $list;
    }


    /**
     * Retrieve a user column by userID
     * @return int
     */
    public function getListCount( $list ) {
        $sql = $this->DB->select( 'SELECT COUNT(cID) FROM contract 
                                   WHERE cID IN (' . addslashes( $list ) . ') AND deleted <> "1"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }
}
?>