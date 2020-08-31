<?php
namespace Markaxis\Employee;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: Tax.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class Tax extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByUserID( $userID ) {
        $sql = $this->DB->select( 'SELECT COUNT(etID) FROM employee_tax
                                   WHERE userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve a user list normally use for building select list
     * @return mixed
     */
    public function getByUserID( $userID, $column ) {
        $sql = $this->DB->select( 'SELECT ' . addslashes( $column ) . ', tg.title, tg.summary
                                   FROM employee_tax et
                                   LEFT JOIN tax_group tg ON ( tg.tgID = et.tgID )
                                   WHERE userID = "' . (int)$userID . '" AND
                                         tg.deleted = "0"',
                                   __FILE__, __LINE__ );

        $list = array( );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list['mainGroup'][$row['tgID']] = $row;

                $sql2 = $this->DB->select( 'SELECT tgID, title, parent, summary
                                            FROM ( SELECT * FROM tax_group WHERE deleted = "0" ORDER BY parent, tgID) tax_group,
                                            ( SELECT @pv := "' . (int)$row['tgID'] . '" ) initialisation
                                              WHERE find_in_set( parent, @pv ) > 0 AND @pv := concat( @pv, ",", tgID )',
                                            __FILE__, __LINE__ );

                if( $this->DB->numrows( $sql2 ) > 0 ) {
                    while( $child = $this->DB->fetch( $sql2 ) ) {
                        $list['mainGroup'][$row['tgID']]['child'][] = $child;
                    }
                }
            }
        }
        return $list;
    }


    /**
     * Retrieve a user list normally use for building select list
     * @return mixed
     */
    public function getListByUserID( $userID ) {
        $sql = $this->DB->select( 'SELECT GROUP_CONCAT(DISTINCT tgID) AS tgID FROM employee_tax
                                   WHERE userID = "' . (int)$userID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function existByTGIDs( $tgIDs ) {
        if( is_array( $tgIDs ) ) {
            $count = count( $tgIDs );

            $sql = $this->DB->select('SELECT CASE WHEN ( 
                                        SELECT COUNT(tgID) as cnt
                                        FROM tax_group
                                        WHERE tgID IN (' . addslashes( implode( ',', $tgIDs ) ) . ') ) = ' . (int)$count . '
                                        THEN 1
                                        ELSE 0 END',
                                      __FILE__, __LINE__);

            return $this->DB->resultData($sql);
        }
        return false;
    }
}
?>