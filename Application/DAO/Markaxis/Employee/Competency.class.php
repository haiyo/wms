<?php
namespace Markaxis\Employee;
use \Application\DAO\DAO;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Component.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Competency extends DAO {


    // Properties


    /**
     * Component Constructor
     * @return void
     */
    function __construct() {
        parent::__construct();
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID, $cID ) {
        $sql = $this->DB->select( 'SELECT COUNT(cID) FROM employee_competency 
                                   WHERE userID = "' . (int)$userID . '" AND
                                         cID = "' . (int)$cID . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByUserID( $userID ) {
        $sql = $this->DB->select( 'SELECT GROUP_CONCAT(c.competency SEPARATOR ";") AS competency 
                                   FROM employee_competency ec
                                   LEFT JOIN competency c ON (c.cID = ec.cID)
                                   WHERE ec.userID = "' . (int)$userID . '"',
                                    __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }
}
?>