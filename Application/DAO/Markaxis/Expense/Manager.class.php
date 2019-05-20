<?php
namespace Markaxis\Expense;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Manager.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Manager extends \DAO {


    // Properties


    /**
     * Manager Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $ecID, $managerID ) {
        $sql = $this->DB->select( 'SELECT COUNT(ecID) FROM expense_claim_manager 
                                   WHERE ecID = "' . (int)$ecID . '" AND
                                         managerID = "' . (int)$managerID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getByecID( $ecID ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT ecm.managerID, ecm.approved, CONCAT( u.fname, \' \', u.lname ) AS name
                                   FROM expense_claim_manager ecm
                                   LEFT JOIN user u ON ( u.userID = ecm.managerID )
                                   WHERE ecm.ecID = "' . (int)$ecID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }
}
?>