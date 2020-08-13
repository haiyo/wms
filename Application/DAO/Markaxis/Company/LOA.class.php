<?php
namespace Markaxis\Company;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: LOA.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LOA extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $loaID ) {
        $sql = $this->DB->select( 'SELECT COUNT(loaID) FROM loa WHERE loaID = "' . (int)$loaID . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getByLoaID( $loaID ) {
        $sql = $this->DB->select( 'SELECT * FROM loa WHERE loaID = "' . (int)$loaID . '"',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            $row = $this->DB->fetch( $sql );
            $row['designation'] = [];

            $sql2 = $this->DB->select( 'SELECT d.dID FROM designation d
                                        LEFT JOIN loa_designation ld ON ( ld.designationID = d.dID )
                                        WHERE ld.loaID = "' . (int)$row['loaID'] . '"',
                                        __FILE__, __LINE__ );

            if( $this->DB->numrows( $sql2 ) > 0 ) {
                while( $row2 = $this->DB->fetch( $sql2 ) ) {
                    $row['designation'][] = $row2['dID'];
                }
            }
            return $row;
        }
        return false;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getContentByDesignationID( $dID ) {
        $sql = $this->DB->select( 'SELECT loa.content FROM loa_designation ld
                                   LEFT JOIN loa loa ON ( loa.loaID = ld.loaID ) 
                                   WHERE ld.designationID = "' . (int)$dID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql )['content'];
        }
        return false;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getResults( $q='', $order='name ASC' ) {
        $list = array( );

        $q = $q ? addslashes( $q ) : '';
        $q = $q ? 'AND ( CONCAT( u.fname, \' \', u.lname ) LIKE "%' . $q . '%" OR title LIKE "%' . $q . '%" )' : '';

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS loa.*, DATE_FORMAT(loa.lastUpdated, "%D %b %Y") AS lastUpdated,
                                          CONCAT( u.fname, " ", u.lname ) AS name
                                   FROM loa loa
                                   LEFT JOIN user u ON ( u.userID = loa.userID )
                                   WHERE 1 = 1 ' . $q . '
                                   ORDER BY ' . $order . $this->limit,
                                   __FILE__, __LINE__ );

        $numRows = $this->DB->numrows( $sql );

        if( $numRows > 0 ) {
            $i = 0;
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$i] = $row;
                $list[$i]['designation'] = [];

                $sql2 = $this->DB->select( 'SELECT d.title FROM designation d
                                            LEFT JOIN loa_designation ld ON ( ld.designationID = d.dID )
                                            WHERE ld.loaID = "' . (int)$row['loaID'] . '"',
                                           __FILE__, __LINE__ );

                if( $this->DB->numrows( $sql2 ) > 0 ) {
                    while( $row2 = $this->DB->fetch( $sql2 ) ) {
                        $list[$i]['designation'][] = $row2['title'];
                    }
                }
                $i++;
            }
        }
        $list['recordsTotal'] = $numRows;
        return $list;
    }
}
?>