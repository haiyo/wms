<?php
namespace Markaxis\Leave;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Designation.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Designation extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $ltID ) {
        $sql = $this->DB->select( 'SELECT COUNT(ldID) FROM leave_designation
                                   WHERE ltID = "' . (int)$ltID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getBylgID( $lgID ) {
        $sql = $this->DB->select( 'SELECT ld.*, d.title
                                   FROM leave_designation ld
                                   LEFT JOIN designation d ON ( d.dID = ld.dID )
                                   WHERE lgID = "' . (int)$lgID . '"',
                                   __FILE__, __LINE__ );

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