<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Payroll.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Payroll extends \DAO {


    // Properties


    /**
     * Payroll Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $prID ) {
        $sql = $this->DB->select( 'SELECT COUNT(prID) FROM payroll WHERE prID = "' . (int)$prID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getPayruns( ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS * FROM payrun pr',
                                    __FILE__, __LINE__ );

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


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getCalculateUserInfo( $userID ) {
        $sql = $this->DB->select( 'SELECT u.fname, u.lname, u.birthday, n.nationality, emp.idnumber, emp.currency, emp.salary,
                                          dpt.name AS department, dsg.title AS designation, cont.type AS contractType, 
                                          pm.method AS paymentMethod, pt.title AS passType, emp_bk.*, bk.name AS bankName,
                                          DATE_FORMAT(emp.startDate, "%D %b %Y") AS startDate, 
                                          DATE_FORMAT(emp.confirmDate, "%D %b %Y") AS confirmDate, 
                                          DATE_FORMAT(emp.endDate, "%D %b %Y") AS endDate
                                   FROM user u
                                          LEFT JOIN nationality n ON ( n.nID = u.nationalityID )
                                          LEFT JOIN employee emp ON ( u.userID = emp.userID )
                                          LEFT JOIN employee_bank emp_bk ON ( u.userID = emp_bk.userID )
                                          LEFT JOIN bank bk ON ( emp_bk.bkID = bk.bkID )
                                          LEFT JOIN department dpt ON ( emp.departmentID = dpt.dID )
                                          LEFT JOIN designation dsg ON ( emp.designationID = dsg.dID )
                                          LEFT JOIN contract cont ON ( emp.contractID = cont.cID )
                                          LEFT JOIN payment_method pm ON ( emp.paymentMethodID = pm.pmID )
                                          LEFT JOIN pass_type pt ON ( emp.passTypeID = pt.ptID )
                                   WHERE u.userID = "' . (int)$userID . '"',
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
    public function getByRange( $startDate, $endDate ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT *, MONTH(startDate) AS startIndex FROM payroll p WHERE startDate 
                                   BETWEEN "' . addslashes( $startDate ) . '" AND "' . addslashes( $endDate ) . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[$row['startIndex']] = $row;
            }
        }
        return $list;
    }
}
?>