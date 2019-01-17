<?php
namespace Markaxis\Employee;
use \Application\DAO\DAO;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: EContact.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class EContact extends DAO {


    // Properties


    /**
     * EContact Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID, $ecID ) {
        $sql = $this->DB->select( 'SELECT COUNT(ecID) FROM employee_econtact 
                                   WHERE userID = "' . (int)$userID . '" AND
                                         ecID = "' . (int)$ecID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getByUserID( $userID, $column ) {
        $sql = $this->DB->select( 'SELECT ' . addslashes( $column ) . ' FROM employee_econtact 
                                   WHERE userID = "' . (int)$userID . '"',
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