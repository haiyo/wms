<?php
namespace Markaxis\Leave;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Type.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Type extends \DAO {


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
        $sql = $this->DB->select( 'SELECT lt.*, GROUP_CONCAT(DISTINCT lg.gender) AS gender, 
                                          GROUP_CONCAT(DISTINCT lo.oID) AS office,
                                          GROUP_CONCAT(DISTINCT ld.dID) AS designation,
                                          GROUP_CONCAT(DISTINCT lc.cID) AS contract,
                                          GROUP_CONCAT(DISTINCT ls.start) AS start,
                                          GROUP_CONCAT(DISTINCT ls.end) AS end,
                                          GROUP_CONCAT(DISTINCT ls.days) AS days,
                                          GROUP_CONCAT(DISTINCT lhc.haveChild) AS haveChild,
                                          GROUP_CONCAT(DISTINCT lcb.cID) AS childBorn,
                                          GROUP_CONCAT(DISTINCT lca.age) AS childAge
                                    FROM `leave_type` lt
                                    LEFT OUTER JOIN leave_gender lg ON (lg.ltID = lt.ltID)
                                    LEFT OUTER JOIN leave_office lo ON (lo.ltID = lt.ltID)
                                    LEFT OUTER JOIN leave_designation ld ON (ld.ltID = lt.ltID)
                                    LEFT OUTER JOIN leave_contract lc ON (lc.ltID = lt.ltID)
                                    LEFT OUTER JOIN leave_structure ls ON (ls.ltID = lt.ltID)
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
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getFullList( ) {
        $sql = $this->DB->select( 'SELECT lt.*, GROUP_CONCAT(DISTINCT lg.gender) AS gender, 
                                          GROUP_CONCAT(DISTINCT lo.oID) AS office,
                                          GROUP_CONCAT(DISTINCT ld.dID) AS designation,
                                          GROUP_CONCAT(DISTINCT lc.cID) AS contract,
                                          GROUP_CONCAT(DISTINCT ls.start) AS start,
                                          GROUP_CONCAT(DISTINCT ls.end) AS end,
                                          GROUP_CONCAT(DISTINCT ls.days) AS days,
                                          GROUP_CONCAT(DISTINCT lhc.haveChild) AS haveChild,
                                          GROUP_CONCAT(DISTINCT lcb.cID) AS childBorn,
                                          GROUP_CONCAT(DISTINCT lca.age) AS childAge
                                    FROM `leave_type` lt
                                    LEFT OUTER JOIN leave_gender lg ON (lg.ltID = lt.ltID)
                                    LEFT OUTER JOIN leave_office lo ON (lo.ltID = lt.ltID)
                                    LEFT OUTER JOIN leave_designation ld ON (ld.ltID = lt.ltID)
                                    LEFT OUTER JOIN leave_contract lc ON (lc.ltID = lt.ltID)
                                    LEFT OUTER JOIN leave_structure ls ON (ls.ltID = lt.ltID)
                                    LEFT OUTER JOIN leave_have_child lhc ON (lhc.ltID = lt.ltID)
                                    LEFT OUTER JOIN leave_child_born lcb ON (lcb.ltID = lt.ltID)
                                    LEFT OUTER JOIN leave_child_age lca ON (lca.ltID = lt.ltID)
                                    GROUP BY lt.ltID',
                                    __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['ltID']] = $row;
            }
        }
        return $list;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getResults( $q='', $order='lt.name ASC' ) {
        $list = array( );

        $q = $q ? addslashes( $q ) : '';
        $q = $q ? 'AND ( lt.name LIKE "%' . $q . '%" )' : '';

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS lt.* FROM leave_type lt
                                   WHERE lt.deleted <> 0 ' . $q . '
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