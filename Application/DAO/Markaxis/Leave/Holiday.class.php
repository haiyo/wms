<?php
namespace Markaxis\Leave;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Holiday.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Holiday extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByhID( $hID ) {
        $sql = $this->DB->select( 'SELECT COUNT(hID) FROM holiday WHERE hID = "' . (int)$hID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getByhID( $hID ) {
        $sql = $this->DB->select( 'SELECT * FROM holiday WHERE hID = "' . (int)$hID . '"',
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
    public function getAll( ) {
        $sql = $this->DB->select( 'SELECT * FROM holiday', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }


    /**
     * Retrieve Events Between a Start and End Timestamp
     * @return mixed
     */
    public function getEventsBetween( $start, $end ) {
        $events = array( );
        $sql = $this->DB->select( 'SELECT * FROM holiday
                                   WHERE date <= "' . addslashes( $end ) . '" AND
                                         date >= "' . addslashes( $start ) . '"',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $row['classNames'] = 'holiday';
                $events[] = $row;
            }
        }
        return $events;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getResults( $q='', $order='h.date ASC' ) {
        $list = array( );

        $q = $q ? addslashes( $q ) : '';
        $q = $q ? 'AND ( h.title LIKE "%' . $q . '%" )' : '';

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS h.*,
                                          DATE_FORMAT( h.date, "%D %M %Y") AS date
                                   FROM holiday h
                                   WHERE 1 = 1 ' . $q . '
                                   ORDER BY ' . $order . $this->limit,
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