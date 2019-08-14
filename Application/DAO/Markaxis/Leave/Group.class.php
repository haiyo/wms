<?php
namespace Markaxis\Leave;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Group.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Group extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $lgID ) {
        $sql = $this->DB->select( 'SELECT COUNT(lgID) FROM leave_group
                                   WHERE ltID = "' . (int)$lgID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByID( $lgID ) {
        $sql = $this->DB->select( 'SELECT * FROM leave_group WHERE lgID = "' . (int)$lgID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Return total count of records
     * @return mixed
     */
    public function getByltID( $ltID ) {
        $sql = $this->DB->select( 'SELECT * FROM leave_group
                                   WHERE ltID = "' . (int)$ltID . '"',
                                   __FILE__, __LINE__ );

        $list = array( );
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
    public function getByltIDs( $ltIDs ) {
        $sql = $this->DB->select( 'SELECT * FROM leave_group
                                   WHERE ltIDs IN (' . implode(',', $ltID ) . ')',
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