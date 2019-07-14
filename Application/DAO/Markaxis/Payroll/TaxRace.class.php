<?php
namespace Markaxis\Payroll;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxRace.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxRace extends \DAO {


    // Properties


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $trID, $traID ) {
        $sql = $this->DB->select( 'SELECT COUNT(traID) FROM tax_race
                                   WHERE trID = "' . (int)$trID . '" AND
                                         traID = "' . (int)$traID . '"',
                                   __FILE__, __LINE__ );

        return $this->DB->resultData( $sql );
    }


    /**
     * Retrieve all user by name and role
     * @return mixed
     */
    public function getByID( $trID, $traID ) {
        $sql = $this->DB->select( 'SELECT * FROM tax_race tra
                                   LEFT JOIN race r ON ( r.rID = tra.raceID )
                                   WHERE trID = "' . (int)$trID . '" AND
                                         traID = "' . (int)$traID . '"',
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

        $sql = $this->DB->select( 'SELECT * FROM tax_race tra
                                   LEFT JOIN race r ON ( r.rID = tra.raceID ) 
                                   WHERE tra.trID = "' . (int)$trID . '"',
                                   __FILE__, __LINE__ );

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
    public function getBytrIDs( $trIDs ) {
        $sql = $this->DB->select( 'SELECT * FROM tax_race WHERE trID IN (' . addslashes( $trIDs ) . ')',
                                   __FILE__, __LINE__ );

        $list = array( );
        if( $this->DB->numrows( $sql ) > 0 ) {
            while( $row = $this->DB->fetch( $sql ) ) {
                $list[] = $row;
            }
        }
        return $list;
    }
}
?>