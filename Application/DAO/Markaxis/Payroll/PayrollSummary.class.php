<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: PayrollSummary.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollSummary extends \DAO {


    // Properties


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getByPuID( $puID ) {
        $sql = $this->DB->select( 'SELECT ps.* FROM payroll_summary ps
                                   LEFT JOIN payroll_user pu ON( pu.puID = ps.puID )
                                   WHERE pu.puID = "' . (int)$puID . '"',
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
    public function getResults( $processDate, $q='', $order='name ASC' ) {
        if( $q ) {
            $q = $q ? addslashes( $q ) : '';
            $q = $q ? 'AND ( CONCAT( u.fname, \' \', u.lname ) LIKE "%' . $q . '%" )' : '';
        }

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS u.userID, CONCAT( u.fname, \' \', u.lname ) AS name,
                                          ps.gross, ps.deduction, ps.net, ps.claim, pl.levies, pc.contributions
                                   FROM payroll_user pu
                                   LEFT JOIN payroll p ON (p.pID = pu.pID)
                                   LEFT JOIN payroll_summary ps ON (ps.puID = pu.puID)
                                   LEFT JOIN ( SELECT puID, SUM(amount) AS levies 
                                                FROM payroll_levy 
                                                GROUP BY puID ) pl ON (pl.puID = pu.puID)
                                   LEFT JOIN ( SELECT puID, SUM(amount) AS contributions 
                                                FROM payroll_contribution 
                                                GROUP BY puID ) pc ON (pc.puID = pu.puID)
                                   LEFT JOIN user u ON (u.userID = pu.userID)
                                   LEFT JOIN employee e ON (e.userID = u.userID)
                                   WHERE p.startDate = "' . addslashes( $processDate ) . '" ' . $q . '
                                   GROUP BY u.userID
                                   ORDER BY ' . $order . $this->limit,
                                   __FILE__, __LINE__ );
        $list = array( );

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