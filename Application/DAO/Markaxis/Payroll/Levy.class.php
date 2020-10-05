<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Levy.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Levy extends \DAO {


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
    public function getChart( $date, $range ) {
        $date = addslashes( $date );

        $date  = addslashes( $date );
        $union = 'SELECT DATE("' . $date . '") as thedate';

        for( $i=1; $i<$range; $i++ ) {
            $union .= ' UNION ALL SELECT DATE(DATE_ADD( "' . $date . '", INTERVAL ' . $i . ' MONTH))';
        }

        $sql = $this->DB->select( 'SELECT d.thedate, COALESCE(SUM(ps.levy), 0) AS levy
                                    FROM (' . $union . ') d 
                                    LEFT OUTER JOIN payroll p on p.startDate = d.thedate 
                                    LEFT OUTER JOIN payroll_summary ps ON ( ps.pID = p.pID ) 
                                    GROUP BY thedate
                                    ORDER BY thedate ASC',
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