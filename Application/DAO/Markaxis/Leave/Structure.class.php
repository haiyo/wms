<?php
namespace Markaxis\Leave;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Structure.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Structure extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $ltID ) {
        $sql = $this->DB->select( 'SELECT COUNT(lsID) FROM leave_structure
                                   WHERE ltID = "' . (int)$ltID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByID( $ltID ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT * FROM leave_structure WHERE ltID = "' . (int)$ltID . '"
                                   ORDER BY lsID DESC',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getBydesignationID( $ldID ) {
        $sql = $this->DB->select( 'SELECT * FROM leave_structure WHERE ldID = "' . (int)$ldID . '"
                                   ORDER BY lsID DESC',
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