<?php
namespace Markaxis\Expense;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Expense.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Expense extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $eiID ) {
        $sql = $this->DB->select( 'SELECT COUNT(prID) FROM expense_item WHERE eiID = "' . (int)$eiID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getList( ) {
        $sql = $this->DB->select( 'SELECT eiID AS id, title FROM expense_item
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
    public function getResults( $q='', $order='ei.type ASC' ) {
        $list = array( );

        $q = $q ? addslashes( $q ) : '';
        $q = $q ? 'AND ( ei.title LIKE "%' . $q . '%" OR ei.max_amount LIKE "%' . $q . '%" )' : '';

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS * FROM expense_item ei
                                   WHERE 1 = 1' . $q . '
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