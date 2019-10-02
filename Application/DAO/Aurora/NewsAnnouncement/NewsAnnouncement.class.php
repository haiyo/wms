<?php
namespace Aurora\NewsAnnouncement;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: NewsAnnouncement.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class NewsAnnouncement extends \DAO {


    // Properties


    /**
     * Retrieve all by userID
     * @return mixed
     */
    public function getList( ) {
        $list = array( );
        $sql = $this->DB->select( 'SELECT *, DATE_FORMAT(na.created, "%D %b %Y") AS created 
                                   FROM news_annoucement na
                                   LEFT JOIN user u ON( u.userID = na.userID )
                                   ORDER BY na.created DESC ' . $this->limit,
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getResults( $q='', $order='name ASC' ) {
        $list = array( );

        $q = $q ? addslashes( $q ) : '';
        $q = $q ? 'AND ( CONCAT( u.fname, \' \', u.lname ) LIKE "%' . $q . '%" OR d.title LIKE "%' . $q . '%" 
                   OR e.idnumber = "' . $q . '" OR u.email1 LIKE "%' . $q . '%" OR e.startdate LIKE "%' . $q . '%"
                   OR c.type LIKE "%' . $q . '%" OR d.title LIKE "%' . $q . '%")' : '';

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS na.*, u.userID, CONCAT( u.fname, \' \', u.lname ) AS createdBy
                                   FROM news_annoucement na
                                   LEFT JOIN user u ON ( u.userID = na.userID )
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