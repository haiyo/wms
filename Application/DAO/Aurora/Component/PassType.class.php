<?php
namespace Aurora\Component;
use \Application\DAO\DAO;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: PassType.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PassType extends DAO {


    // Properties


    /**
     * PassType Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $ptID ) {
        $sql = $this->DB->select( 'SELECT COUNT(ptID) FROM passtype WHERE ptID = "' . (int)$ptID . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getList( ) {
        $sql = $this->DB->select( 'SELECT e.ptID AS parentID, r.ptID AS id, r.title, r.parent
                                   FROM passtype r
                                   LEFT JOIN passtype e ON r.parent = e.ptID
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