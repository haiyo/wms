<?php
namespace Markaxis\Expense;
use \Library\Util\Money;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Claim.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Claim extends \DAO {


    // Properties


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
     * Return total count of records
     * @return int
     */
    public function isFoundByEcIDUserID( $ecID, $userID, $status ) {
        $sql = $this->DB->select( 'SELECT COUNT(ecID) FROM expense_claim 
                                   WHERE ecID = "' . (int)$ecID . '" AND
                                         userID = "' . (int)$userID . '" AND
                                         status = "' . (int)$status . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getByEcID( $ecID ) {
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
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getByUserIDStatus( $userID, $startDate, $endDate, $status ) {
        $sql = $this->DB->select( 'SELECT ec.*, u.name AS uploadName, u.hashName
                                   FROM expense_claim ec
                                   LEFT JOIN upload u ON ( u.uID = ec.uID )
                                   WHERE ec.userID = "' . (int)$userID . '" AND 
                                         ec.status = "' . (int)$status . '" AND
                                         ec.created BETWEEN "' . addslashes( $startDate ) . '" AND "' . addslashes( $endDate ) . '" AND
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


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getApprovedByUserID( $userID, $startDate='', $endDate='' ) {
        $date = '';
        if( $startDate && $endDate ) {
            $date = ' AND ( ec.created BETWEEN "' . addslashes( $startDate ) . '" AND "' . addslashes( $endDate ) . '" )';
        }

        $sql = $this->DB->select( 'SELECT ec.*, u.name AS uploadName, u.hashName
                                   FROM expense_claim ec
                                   LEFT JOIN upload u ON ( u.uID = ec.uID )
                                   WHERE ec.userID = "' . (int)$userID . '" AND 
                                         (ec.status = "1" OR ec.status = "2") AND
                                         ec.cancelled <> "1"' . $date,
                                   __FILE__, __LINE__ );
        $list = array( );

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
    public function getResults( $userID, $q='', $order='ei.title ASC' ) {
        $list = array( );

        $q = $q ? addslashes( $q ) : '';
        $q = $q ? 'AND ( ei.title LIKE "%' . $q . '%" OR ec.descript LIKE "%' . $q . '%" )' : '';

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS ec.ecID AS ecID, ec.userID AS userID, 
                                          ec.descript, ec.amount, ec.uID, ec.status, ec.cancelled,
                                          DATE_FORMAT(ec.created, "%D %b %Y") AS created,
                                          up.name AS uploadName, up.hashName, ei.title,
                                          c.currencyCode, c.currencySymbol
                                   FROM expense_claim ec
                                   LEFT JOIN expense_item ei ON ( ei.eiID = ec.eiID )
                                   LEFT JOIN upload up ON ( up.uID = ec.uID )
                                   LEFT JOIN employee emp ON ( emp.userID = ec.userID )
                                   LEFT JOIN office o ON ( o.oID = emp.officeID )
                                   LEFT JOIN country c ON ( c.cID = o.countryID )
                                   WHERE ec.userID = "' . (int)$userID . '" ' . $q . '
                                   ORDER BY ec.created DESC, ' . $order . $this->limit,
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $row['amount'] = Money::format( $row['amount'] );
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
        $sql = $this->DB->select( 'SELECT ec.*, ei.title AS itemTitle, u.userID, u.fname, u.lname, 
                                          up.name AS uploadName, up.hashName, c.currencyCode, c.currencySymbol
                                   FROM expense_claim ec
                                   LEFT JOIN expense_item ei ON ( ei.eiID = ec.eiID )
                                   LEFT JOIN expense_claim_manager ecm ON ( ecm.ecID = ec.ecID )
                                   LEFT JOIN upload up ON ( up.uID = ec.uID )
                                   LEFT JOIN user u ON ( u.userID = ec.userID )
                                   LEFT JOIN country c ON ( c.cID = u.countryID )
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


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getRequest( $userID ) {
        $sql = $this->DB->select( 'SELECT ec.*, ei.title AS itemTitle, u.userID, u.fname, u.lname, 
                                          up.name AS uploadName, up.hashName, c.currencyCode, c.currencySymbol
                                   FROM expense_claim ec
                                   LEFT JOIN expense_item ei ON ( ei.eiID = ec.eiID )
                                   LEFT JOIN user u ON ( u.userID = ec.userID )
                                   LEFT JOIN upload up ON ( up.uID = ec.uID )
                                   LEFT JOIN country c ON ( c.cID = u.countryID )
                                   WHERE ec.userID = "' . (int)$userID . '" AND 
                                         ec.status = "0" AND
                                         ec.cancelled <> "1"
                                   ORDER BY ec.created desc',
                                   __FILE__, __LINE__ );
        $list = array( );

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
    public function getChart( $date ) {
        $date = addslashes( $date );

        $sql = $this->DB->select( 'SELECT p.startDate, COALESCE(SUM(ps.claim), 0) AS claim
                                    FROM (SELECT DATE("' . $date . '") as thedate union all
                                          SELECT DATE(DATE_SUB( "' . $date . '", INTERVAL 1 MONTH)) UNION ALL
                                          SELECT DATE(DATE_SUB( "' . $date . '", INTERVAL 2 MONTH)) UNION ALL
                                          SELECT DATE(DATE_SUB( "' . $date . '", INTERVAL 3 MONTH)) UNION ALL
                                          SELECT DATE(DATE_SUB( "' . $date . '", INTERVAL 4 MONTH)) UNION ALL
                                          SELECT DATE(DATE_SUB( "' . $date . '", INTERVAL 5 MONTH)) UNION ALL
                                          SELECT DATE(DATE_SUB( "' . $date . '", INTERVAL 6 MONTH)) UNION ALL
                                          SELECT DATE(DATE_SUB( "' . $date . '", INTERVAL 7 MONTH)) UNION ALL
                                          SELECT DATE(DATE_SUB( "' . $date . '", INTERVAL 8 MONTH)) UNION ALL
                                          SELECT DATE(DATE_SUB( "' . $date . '", INTERVAL 9 MONTH)) UNION ALL
                                          SELECT DATE(DATE_SUB( "' . $date . '", INTERVAL 10 MONTH)) UNION ALL
                                          SELECT DATE(DATE_SUB( "' . $date . '", INTERVAL 11 MONTH))) d 
                                    LEFT OUTER JOIN payroll p on p.startDate = d.thedate 
                                    LEFT OUTER JOIN payroll_summary ps ON ( ps.pID = p.pID ) 
                                    GROUP BY thedate
                                    ORDER BY thedate ASC',
                                    __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = (int)$row['claim'];
            }
        }
        return $list;
    }
}
?>