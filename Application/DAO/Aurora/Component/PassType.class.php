<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: PassType.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PassType extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $ptID ) {
        $sql = $this->DB->select( 'SELECT COUNT(ptID) FROM pass_type WHERE ptID = "' . (int)$ptID . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all user roles
     * @return mixed
     */
    public function getByID( $ptID ) {
        $sql = $this->DB->select( 'SELECT * FROM pass_type WHERE ptID = "' . (int)$ptID . '"',
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
        $sql = $this->DB->select( 'SELECT e.ptID AS parentID, r.ptID AS id, r.title, r.parent
                                   FROM pass_type r
                                   LEFT JOIN pass_type e ON r.parent = e.ptID
                                   ORDER BY COALESCE(parentID, r.ptID), r.ptID', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }
}
?>