<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxRule.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxRule extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $trID ) {
        $sql = $this->DB->select( 'SELECT COUNT(trID) FROM tax_rule WHERE trID = "' . (int)$trID . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getAll( ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT * FROM tax_rule tr
                                   LEFT JOIN country c ON ( c.cID = tr.countryID ) ',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $row['applyValue'] = (float)$row['applyValue'];
                $list[$row['trID']] = $row;
            }
        }
        return $list;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getBytrID( $trID ) {
        $sql = $this->DB->select( 'SELECT * FROM tax_rule tr
                                   LEFT JOIN country c ON ( c.cID = tr.countryID )
                                   WHERE tr.trID = "' . (int)$trID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            $row = $this->DB->fetch( $sql );
            $row['applyValue'] = (float)$row['applyValue'];
            return $row;
        }
        return false;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getBytgIDs( $tgIDs ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT tr.trID, tg.title, tr.applyType, tr.applyValueType, tr.applyValue
                                   FROM tax_rule tr
                                   LEFT JOIN tax_group tg ON ( tg.tgID = tr.tgID )
                                   LEFT JOIN country c ON ( c.cID = tr.countryID )
                                   LEFT JOIN tax_pay_item tpi ON ( tpi.trID = tr.trID ) 
                                   WHERE tr.tgID IN (' . addslashes( $tgIDs ) . ')',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $row['applyValue'] = (float)$row['applyValue'];
                $list[$row['trID']] = $row;
            }
        }
        return $list;
    }
}
?>