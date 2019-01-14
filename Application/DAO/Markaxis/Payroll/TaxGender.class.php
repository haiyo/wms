<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxGender.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxGender extends \DAO {


    // Properties


    /**
     * TaxComputing Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $trID, $tgID ) {
        $sql = $this->DB->select( 'SELECT COUNT(tdID) FROM tax_gender
                                   WHERE trID = "' . (int)$trID . '" AND
                                         tgID = "' . (int)$tgID . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getBytrID( $trID ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT * FROM tax_gender WHERE trID = "' . (int)$trID . '"',
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