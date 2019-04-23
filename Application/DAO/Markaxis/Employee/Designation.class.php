<?php
namespace Markaxis\Employee;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Designation.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Designation extends \DAO {


    // Properties


    /**
     * Designation Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getList( ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT * FROM designation', __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['dID']] = $row['title'];
            }
        }
        return $list;
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getGroupList( ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT * FROM designation WHERE parent = 0
                                   ORDER BY title',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['dID']] = $row['title'];
            }
        }
        return $list;
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getEmptyGroupList( ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT d.dID FROM designation d
                                   LEFT JOIN designation dd ON d.dID = dd.parent
                                   WHERE d.parent = 0 AND dd.dID IS NULL',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row['dID'];
            }
        }
        return $list;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getResults( $q='', $order='parentTitle ASC' ) {
        $list = array( );

        $q = $q ? addslashes( $q ) : '';
        $q = $q ? 'AND ( d.title LIKE "%' . $q . '%" )' : '';

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS IFNULL( dd.dID, 0 ) AS parentID, dd.title AS parentTitle,
                                          CONCAT(dd.dID, "-", dd.title) AS idParentTitle, 
                                          d.dID AS dID, d.title, d.descript, d.parent, IFNULL( e.empCount, 0 ) AS empCount,
                                          ( SELECT COUNT(*) FROM designation WHERE parent = d.dID ) AS childCount
                                   FROM designation d
                                   LEFT JOIN designation dd ON d.parent = dd.dID
                                   LEFT JOIN ( SELECT designationID, COUNT(eID) as empCount FROM employee e
                                               LEFT JOIN user u ON e.userID = u.userID
                                               WHERE u.deleted <> "1" AND e.resigned <> "1" 
                                               GROUP BY designationID ) e ON e.designationID = d.dID
                                   WHERE d.parent <> 0 ' . $q . '
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
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getBydID( $dID ) {
        $sql = $this->DB->select( 'SELECT * FROM designation d
                                   WHERE d.dID = "' . (int)$dID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }
}
?>