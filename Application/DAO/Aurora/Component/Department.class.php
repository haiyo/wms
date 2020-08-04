<?php
namespace Aurora\Component;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Department.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Department extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByID( $dID ) {
        $sql = $this->DB->select( 'SELECT COUNT(dID) FROM department
                                   WHERE dID = "' . (int)$dID . '" AND deleted <> "1"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all user roles
     * @return mixed
     */
    public function getByID( $dID ) {
        $sql = $this->DB->select( 'SELECT * FROM department WHERE dID = "' . (int)$dID . '" AND deleted <> "1"',
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
        $sql = $this->DB->select( 'SELECT * FROM department WHERE deleted <> "1"
                                   ORDER BY name', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['dID']] = $row['name'];
            }
        }
        return $list;
    }
}
?>