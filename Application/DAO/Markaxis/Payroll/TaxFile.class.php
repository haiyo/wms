<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxFile.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxFile extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $piID ) {
        $sql = $this->DB->select( 'SELECT COUNT(piID) FROM payroll_item 
                                   WHERE piID = "' . (int)$piID . '" AND deleted <> "1"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getList( ) {
        $sql = $this->DB->select( 'SELECT piID AS id, title FROM payroll_item
                                   WHERE deleted <> "1"
                                   ORDER BY title', __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['id']] = $row['title'];
            }
        }
        return $list;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getResults( $q, $order='pi.title DESC' ) {
        $list = array( );

        $q = $q ? addslashes( $q ) : '';
        $q = $q ? 'AND pi.title LIKE "%' . $q . '%"' : '';

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS *, CONCAT( u.fname, \' \', u.lname ) AS name
                                   FROM taxfile tf
                                   LEFT JOIN user u ON ( u.userID = tf.authUserID )
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