<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Designation.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Designation extends \DAO {


    // Properties


    /**
     * Designation Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $dID ) {
        $sql = $this->DB->select( 'SELECT COUNT(dID) FROM designation 
                                   WHERE dID = "' . (int)$dID . '" AND deleted <> "1"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all user roles
     * @return mixed
     */
    public function getByID( $dID ) {
        $sql = $this->DB->select( 'SELECT * FROM designation WHERE dID = "' . (int)$dID . '" AND deleted <> "1"',
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
        $sql = $this->DB->select( 'SELECT e.dID AS parentID, r.dID AS id, r.title, r.parent
                                   FROM designation r
                                   LEFT JOIN designation e ON r.parent = e.dID
                                   ORDER BY COALESCE(parentID, r.dID), r.dID', __FILE__, __LINE__ );

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
    public function getIDList( ) {
        $sql = $this->DB->select( 'SELECT dID FROM designation', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['dID']] = $row;
            }
        }
        return $list;
    }


    /**
     * Retrieve a user column by userID
     * @return int
     */
    public function getListCount( $list ) {
        $sql = $this->DB->select( 'SELECT COUNT(dID) FROM designation 
                                   WHERE dID IN (' . addslashes( $list ) . ')',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }
}
?>