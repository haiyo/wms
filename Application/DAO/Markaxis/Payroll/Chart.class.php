<?php
namespace Markaxis\Payroll;

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
        $date = addslashes( $date );

        $sql = $this->DB->select( 'SELECT p.startDate, COALESCE(SUM(ps.net), 0) AS salary
                                    FROM (SELECT DATE("' . $date . '") as thedate union all
                                          SELECT DATE(DATE_SUB( "' . $date . '", INTERVAL 1 MONTH)) UNION ALL
                                          SELECT DATE(DATE_SUB( "' . $date . '", INTERVAL 2 MONTH)) UNION ALL
                                          SELECT DATE(DATE_SUB( "' . $date . '", INTERVAL 3 MONTH)) UNION ALL
                                          SELECT DATE(DATE_SUB( "' . $date . '", INTERVAL 4 MONTH)) UNION ALL
                                          SELECT DATE(DATE_SUB( "' . $date . '", INTERVAL 5 MONTH)) UNION ALL
                                          SELECT DATE(DATE_SUB( "' . $date . '", INTERVAL 6 MONTH)) UNION ALL
                                          SELECT DATE(DATE_SUB( "' . $date . '", INTERVAL 7 MONTH)) UNION ALL
                                          SELECT DATE(DATE_SUB( "' . $date . '", INTERVAL 8 MONTH)) UNION ALL
                                          SELECT DATE(DATE_SUB( "' . $date . '", INTERVAL 9 MONTH)) UNION ALL
                                          SELECT DATE(DATE_SUB( "' . $date . '", INTERVAL 10 MONTH)) UNION ALL
                                          SELECT DATE(DATE_SUB( "' . $date . '", INTERVAL 11 MONTH))) d 
                                    LEFT OUTER JOIN payroll p on p.startDate = d.thedate 
                                    LEFT OUTER JOIN payroll_summary ps ON ( ps.pID = p.pID ) 
                                    GROUP BY thedate
                                    ORDER BY thedate ASC',
                                    __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = (int)$row['salary'];
            }
        }
        return $list;
    }
}
?>