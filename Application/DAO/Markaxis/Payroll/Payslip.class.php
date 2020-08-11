<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Payslip.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Payslip extends \DAO {


    // Properties


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getResults( $userID, $order='name ASC' ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT p.startDate, pm.method AS paymentMethod, bk.name AS bankName,
                                          emp.userID, emp_bk.number AS acctNumber,
                                          DATE_FORMAT(p.endDate, "%D %b %Y") AS period,
                                          DATE_FORMAT(p.created, "%D %b %Y") AS created
                                   FROM payroll_user pu
                                        LEFT JOIN payroll p ON ( p.pID = pu.pID )
                                        LEFT JOIN employee emp ON ( pu.userID = emp.userID )
                                        LEFT JOIN employee_bank emp_bk ON ( pu.userID = emp_bk.userID )
                                        LEFT JOIN bank bk ON ( emp_bk.bkID = bk.bkID )
                                        LEFT JOIN payment_method pm ON ( emp.paymentMethodID = pm.pmID )
                                        LEFT JOIN pass_type pt ON ( emp.passTypeID = pt.ptID )
                                   WHERE pu.userID = "' . (int)$userID . '" AND
                                         pu.released = "1"
                                   GROUP BY p.pID
                                   ORDER BY ' . $order . $this->limit,
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
}
?>