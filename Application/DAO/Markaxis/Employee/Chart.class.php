<?php
namespace Markaxis\Employee;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Chart.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Chart extends \DAO {


    // Properties


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getChart( $date ) {
        $sql = $this->DB->select( 'SELECT COUNT(e.eID) AS empCount
                                   FROM employee e
                                   WHERE -- e.resigned = "0" AND 
                                   e.startDate BETWEEN DATE_SUB( "' . addslashes( $date ) . '", INTERVAL 11 MONTH) AND 
                                                                 "' . addslashes( $date ) . '" 
                                   GROUP BY Month',
                                   __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row['empCount'];
            }
        }
        return $list;
    }
}
?>