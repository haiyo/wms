<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: PayrollUser.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollUser extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $pID ) {
        $sql = $this->DB->select( 'SELECT COUNT(puID) FROM payroll_user WHERE pID = "' . (int)$pID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getUserPayroll( $pID, $userID ) {
        $sql = $this->DB->select( 'SELECT * FROM payroll_user 
                                   WHERE userID = "' . (int)$userID . '" AND
                                         pID = "' . (int)$pID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }
}
?>