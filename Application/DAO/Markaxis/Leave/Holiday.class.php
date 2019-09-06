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
    public function isFound( $ltID ) {
        $sql = $this->DB->select( 'SELECT COUNT(ltID) FROM leave_type 
                                   WHERE ltID = "' . (int)$ltID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByID( $ltID ) {
        $sql = $this->DB->select( 'SELECT lt.*, GROUP_CONCAT(DISTINCT lhc.haveChild) AS haveChild,
                                          GROUP_CONCAT(DISTINCT lcb.cID) AS childBorn,
                                          GROUP_CONCAT(DISTINCT lca.age) AS childAge
                                    FROM `leave_type` lt
                                    LEFT OUTER JOIN leave_have_child lhc ON (lhc.ltID = lt.ltID)
                                    LEFT OUTER JOIN leave_child_born lcb ON (lcb.ltID = lt.ltID)
                                    LEFT OUTER JOIN leave_child_age lca ON (lca.ltID = lt.ltID)
                                    WHERE lt.ltID = "' . (int)$ltID . '"',
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
        $sql = $this->DB->select( 'SELECT ltID, name FROM leave_type', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['ltID']] = $row['name'];
            }
        }
        return $list;
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


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getEvents( $startDate, $endDate ) {
        $sql = $this->DB->select( 'SELECT h.*, h.date AS start FROM holiday h
                                   WHERE h.date BETWEEN "' . addslashes( $startDate ) . '" AND 
                                                        "' . addslashes( $endDate ) . '"',
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