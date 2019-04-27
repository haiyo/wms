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
     * TaxRule Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


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
    public function getAll( $officeID=false ) {
        $list = array( );

        $where = $officeID ? 'WHERE o.oID = "' . (int)$officeID . '"' : '';

        $sql = $this->DB->select( 'SELECT * FROM tax_rule tr 
                                   LEFT JOIN office o ON ( o.oID = tr.officeID )
                                   LEFT JOIN country c ON ( c.cID = o.countryID ) ' .
                                   $where,
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
                                   LEFT JOIN office o ON ( o.oID = tr.officeID )
                                   LEFT JOIN country c ON ( c.cID = o.countryID )
                                   WHERE trID = "' . (int)$trID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            $row = $this->DB->fetch( $sql );
            $row['applyValue'] = (float)$row['applyValue'];
            return $row;
        }
        return false;
    }
}
?>