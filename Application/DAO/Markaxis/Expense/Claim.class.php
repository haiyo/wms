<?php
namespace Markaxis\Expense;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Claim.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Claim extends \DAO {


    // Properties


    /**
     * Claim Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $ecID ) {
        $sql = $this->DB->select( 'SELECT COUNT(ecID) FROM expense_claim WHERE ecID = "' . (int)$ecID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getByecID( $ecID ) {
        $sql = $this->DB->select( 'SELECT ec.*, u.name AS uploadName, u.hashName
                                   FROM expense_claim ec
                                   LEFT JOIN upload u ON ( u.uID = ec.uID )
                                   WHERE ec.ecID = "' . (int)$ecID . '" AND ec.cancelled <> "1"',
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
    public function getResults( $userID, $q='', $order='ei.title ASC' ) {
        $list = array( );

        $q = $q ? addslashes( $q ) : '';
        $q = $q ? 'AND ( ei.title LIKE "%' . $q . '%" OR ec.descript LIKE "%' . $q . '%" )' : '';

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS ec.ecID AS ecID, ec.userID AS userID, 
                                          ec.descript, ec.amount, ec.uID, ec.status, ec.cancelled,
                                          DATE_FORMAT(ec.created, "%D %b %Y") AS created,
                                          u.name AS uploadName, u.hashName, c.code, c.symbol, ei.title
                                   FROM expense_claim ec
                                   LEFT JOIN expense_item ei ON ( ei.eiID = ec.eiID )
                                   LEFT JOIN currency c ON ( c.cID = ec.currencyID )
                                   LEFT JOIN upload u ON ( u.uID = ec.uID )
                                   WHERE ec.userID = "' . (int)$userID . '" ' . $q . '
                                   ORDER BY ec.created DESC, ' . $order . $this->limit,
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
    public function getPendingAction( $userID ) {
        $sql = $this->DB->select( 'SELECT ec.*, ei.title AS itemTitle, u.fname, u.lname, 
                                          up.name AS uploadName, up.hashName
                                   FROM expense_claim ec
                                   LEFT JOIN expense_item ei ON ( ei.eiID = ec.eiID )
                                   LEFT JOIN expense_claim_manager ecm ON ( ecm.ecID = ec.ecID )
                                   LEFT JOIN upload up ON ( up.uID = ec.uID )
                                   LEFT JOIN user u ON ( u.userID = ec.userID )
                                   WHERE ecm.managerID = "' . (int)$userID . '" AND 
                                         ecm.approved = "0" AND
                                         ec.cancelled <> "1"',
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