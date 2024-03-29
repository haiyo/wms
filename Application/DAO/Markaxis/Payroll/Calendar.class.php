<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Calendar.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Calendar extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundBypcID( $pcID ) {
        $sql = $this->DB->select( 'SELECT COUNT(pcID) FROM pay_calendar WHERE pcID = "' . (int)$pcID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getBypcID( $pcID ) {
        $sql = $this->DB->select( 'SELECT * FROM pay_calendar  WHERE pcID = "' . (int)$pcID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getList( ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT pcID, title FROM pay_calendar pc', __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['pcID']] = $row['title'];
            }
        }
        return $list;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getCalResults( ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS * FROM pay_calendar pc',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        $sql = $this->DB->select( 'SELECT FOUND_ROWS()', __FILE__, __LINE__ );
        $row = $this->DB->fetch( $sql );
        $list['recordsTotal'] = $row['FOUND_ROWS()'];
        return $list;
    }
}
?>