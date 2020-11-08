<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: UserTax.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserTax extends \DAO {


    // Properties


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getByPuID( $puID ) {
        $sql = $this->DB->select( 'SELECT * FROM payroll_user_tax
                                   WHERE puID = "' . (int)$puID . '"',
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
    public function getTotalCPFByUserIDRange( $userID, $startDate, $endDate ) {
        $sql = $this->DB->select( 'SELECT SUM(put.amount) AS amount FROM `payroll` p
                                   LEFT JOIN payroll_user pu ON ( pu.pID = p.pID )
                                   LEFT JOIN payroll_user_tax put ON ( put.puID = pu.puID )
                                   WHERE p.startDate BETWEEN CAST("' . addslashes( $startDate ) . '" AS DATE) AND 
                                                             CAST("' . addslashes( $endDate ) . '" AS DATE) AND
                                         pu.userID = "' . (int)$userID . '" AND
                                         put.title LIKE "%CPF%" AND
                                         p.completed = "1"',
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
    public function getTotalDonationByUserIDRange( $userID, $startDate, $endDate ) {
        $sql = $this->DB->select( 'SELECT SUM(put.amount) AS amount FROM `payroll` p
                                   LEFT JOIN payroll_user pu ON ( pu.pID = p.pID )
                                   LEFT JOIN payroll_user_tax put ON ( put.puID = pu.puID )
                                   WHERE p.startDate BETWEEN CAST("' . addslashes( $startDate ) . '" AS DATE) AND 
                                                             CAST("' . addslashes( $endDate ) . '" AS DATE) AND
                                         pu.userID = "' . (int)$userID . '" AND
                                         put.title LIKE "%CDAC%" AND
                                         p.completed = "1"',
                                    __FILE__, __LINE__ );


        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }
}
?>