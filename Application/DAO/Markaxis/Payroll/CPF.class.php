<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: CPF.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class CPF extends \DAO {


    // Properties


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getTotalByDate( $date, $type ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT COUNT(*) AS count, SUM(put.amount) AS totalAmt
                                   FROM payroll_user_tax put
                                   LEFT JOIN payroll_user pu ON ( pu.puID = put.puID )
                                   LEFT JOIN payroll p ON ( p.pID = pu.pID )
                                   WHERE put.title LIKE "%' . addslashes( $type ) . '%" AND
                                         p.startDate = "' . addslashes( $date ) . '" AND
                                         p.completed = "1"
                                   GROUP BY p.pID',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return $list;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getTaxByUserDate( $date ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT u.userID, CONCAT(fname," ",lname) AS name, u.nric, 
                                          e.resigned, e.startDate, e.endDate,  pu.puID,
                                          put.amount, put.title
                                   FROM payroll_user_tax put
                                   LEFT JOIN payroll_user pu ON ( pu.puID = put.puID )
                                   LEFT JOIN user u ON ( u.userID = pu.userID )
                                   LEFT JOIN employee e ON ( e.userID = pu.userID )
                                   LEFT JOIN payroll p ON ( p.pID = pu.pID )
                                   WHERE p.startDate = "' . addslashes( $date ) . '" AND
                                         p.completed = "1"',
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
    public function getGrossBypuID( $puID ) {
        $sql = $this->DB->select( 'SELECT gross FROM payroll_summary WHERE puID = "' . (int)$puID . '"',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql )['gross'];
        }
        return 0;
    }
}
?>