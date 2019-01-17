<?php
namespace Aurora\Component;
use \Application\DAO\DAO;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Designation.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Designation extends DAO {


    // Properties


    /**
     * Designation Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $dID ) {
        $sql = $this->DB->select( 'SELECT COUNT(dID) FROM designation WHERE dID = "' . (int)$dID . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getList( ) {
        $sql = $this->DB->select( 'SELECT e.dID AS parentID, r.dID AS id, r.title, r.parent
                                   FROM designation r
                                   LEFT JOIN designation e ON r.parent = e.dID
                                   WHERE r.active <> "0"
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
        $sql = $this->DB->select( 'SELECT dID FROM designation WHERE active <> "0"', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['dID']] = $row;
            }
        }
        return $list;
    }
}
?>