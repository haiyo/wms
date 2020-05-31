<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: PayrollContribution.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollContribution extends \DAO {


    // Properties


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getByPuID( $puID ) {
        $sql = $this->DB->select( 'SELECT * FROM payroll_contribution 
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
    public function getChart( $date ) {
        $sql = $this->DB->select( 'SELECT SUM(ps.contribution) AS contribution FROM payroll p
                                   LEFT JOIN payroll_summary ps ON ( ps.pID = p.pID )
                                   WHERE p.startDate BETWEEN DATE_SUB( "' . addslashes( $date ) . '", INTERVAL 11 MONTH) AND 
                                         "' . addslashes( $date ) . '" 
                                   GROUP BY p.startDate',
                                    __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = (int)$row['contribution'];
            }
        }
        return $list;
    }
}
?>