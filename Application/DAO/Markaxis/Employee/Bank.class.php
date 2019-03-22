<?php
namespace Markaxis\Employee;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Bank.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Bank extends \DAO {


    // Properties


    /**
     * Bank Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByID( $ebID ) {
        $sql = $this->DB->select( 'SELECT COUNT(ebID) FROM employee_bank
                                   WHERE ebID = "' . (int)$ebID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all user roles
     * @return mixed
     */
    public function getByUserID( $userID ) {
        $sql = $this->DB->select( 'SELECT * FROM employee_bank eb
                                   LEFT JOIN bank b on b.bkID = eb.ebID
                                   WHERE userID = "' . (int)$userID . '"',
            __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }
}
?>