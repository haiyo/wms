<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Employee.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Employee extends \DAO {


    // Properties


    /**
     * Retrieve a user column by userID
     * @return mixed
     */
    public function getProcessInfo( $userID ) {
        $sql = $this->DB->select( 'SELECT u.userID, CONCAT( u.fname, " ", u.lname ) AS name,
                                          u.birthday, n.nationality, e.idnumber, 
                                          d.title AS designation, c.type AS contractType, 
                                          pt.title AS passType,
                                          DATE_FORMAT(e.startDate, "%D %b %Y") AS startDate, 
                                          DATE_FORMAT(e.confirmDate, "%D %b %Y") AS confirmDate, 
                                          DATE_FORMAT(e.endDate, "%D %b %Y") AS endDate
                                   FROM employee e
                                   LEFT JOIN user u ON ( u.userID = e.userID )
                                   LEFT JOIN nationality n ON ( n.nID = u.nationalityID )
                                   LEFT JOIN designation d ON ( d.dID = e.designationID )
                                   LEFT JOIN contract c ON ( c.cID = e.contractID )
                                   LEFT JOIN pass_type pt ON ( pt.ptID = e.passTypeID )
                                   WHERE e.resigned <> "1" AND e.userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }
}
?>