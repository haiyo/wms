<?php
namespace Markaxis\Company;
use \Library\Helper\Aurora\DayHelper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Office.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Office extends \DAO {


    // Properties


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getResults( $q='', $order='name ASC' ) {
        $list = array( );

        $q = $q ? addslashes( $q ) : '';
        $q = $q ? 'AND ( o.name LIKE "%' . $q . '%" OR o.address LIKE "%' . $q . '%" 
                       OR c.country LIKE "%' . $q . '%" )' : '';

        $sql = $this->DB->select( 'SELECT SQL_CALC_FOUND_ROWS o.oID, o.name, o.address, c.name as country, 
                                          IFNULL( e.empCount, 0 ) AS empCount, o.workDayFrom, o.workDayTo,
                                          TIME_FORMAT( openTime, "%l:%i %p" ) AS openTime, 
                                          TIME_FORMAT( closeTime, "%l:%i %p" ) AS closeTime,
                                          main
                                   FROM office o
                                   LEFT JOIN country c ON ( o.countryID = c.cID )
                                   LEFT JOIN ( SELECT officeID, COUNT(eID) as empCount FROM employee e
                                               LEFT JOIN user u ON e.userID = u.userID
                                               WHERE u.deleted <> "1" AND e.resigned <> "1" GROUP BY officeID ) e ON e.officeID = o.oID
                                   WHERE o.deleted <> "1" ' . $q . '
                                   ORDER BY ' . $order . $this->limit,
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $row['workDays'] = '';

                if( $row['workDayFrom'] && $row['workDayTo'] ) {
                    $row['workDays'] = DayHelper::getL10nNumericValueList( )[$row['workDayFrom']] . ' - ' .
                                       DayHelper::getL10nNumericValueList( )[$row['workDayTo']];
                }
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