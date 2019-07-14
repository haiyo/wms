<?php
namespace Markaxis\Employee;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Citizenship.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Citizenship extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $id ) {
        $sql = $this->DB->select( 'SELECT COUNT(id) FROM employee_citizenship WHERE id = "' . (int)$id . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getList( ) {
        $sql = $this->DB->select( 'SELECT * FROM employee_citizenship', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['id']] = $row['name'];
            }
        }
        return $list;
    }
}
?>