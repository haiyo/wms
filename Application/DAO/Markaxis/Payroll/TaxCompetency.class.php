<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxCompetency.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxCompetency extends \DAO {


    // Properties


    /**
     * TaxCompetency Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $trID, $cID ) {
        $sql = $this->DB->select( 'SELECT COUNT(tcID) FROM tax_competency 
                                   WHERE trID = "' . (int)$trID . '" AND
                                         competency = "' . (int)$cID . '"',
                                    __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getBytrID( $trID ) {
        $list = array( );

        $sql = $this->DB->select( 'SELECT * FROM tax_competency  tc
                                   LEFT JOIN competency c ON ( c.cID = tc.competency )
                                   WHERE trID = "' . (int)$trID . '"', __FILE__, __LINE__ );

        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }
}
?>