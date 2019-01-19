<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxContract.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxContract extends \DAO {


    // Properties


    /**
     * TaxContract Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $trID, $tcID ) {
        $sql = $this->DB->select( 'SELECT COUNT(tdID) FROM tax_contract
                                   WHERE trID = "' . (int)$trID . '" AND
                                         tcID = "' . (int)$tcID . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getByID( $trID, $tcID ) {
        $sql = $this->DB->select( 'SELECT * FROM tax_contract tc
                                   LEFT JOIN contract c ON ( c.cID = tc.contract )
                                   WHERE trID = "' . (int)$trID . '" AND
                                   tcID = "' . (int)$tcID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            return $this->DB->fetch( $sql );
        }
        return false;
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getBytrID( $trID ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT * FROM tax_contract tc
                                   LEFT JOIN contract c ON ( c.cID = tc.contract ) 
                                   WHERE trID = "' . (int)$trID . '"',
                                   __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }
}
?>