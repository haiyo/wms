<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: PayrollLevy.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class PayrollLevy extends \DAO {


    // Properties


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getByPuID( $puID ) {
        $sql = $this->DB->select( 'SELECT * FROM payroll_levy
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
        $sql = $this->DB->select( 'SELECT SUM(ps.levy) AS levy FROM payroll p
                                   LEFT JOIN payroll_summary ps ON ( ps.pID = p.pID )
                                   WHERE p.startDate BETWEEN DATE_SUB( "' . addslashes( $date ) . '", INTERVAL 11 MONTH) AND 
                                         "' . addslashes( $date ) . '" 
                                   GROUP BY p.startDate',
                                    __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = (int)$row['levy'];
            }
        }
        return $list;
    }
}
?>